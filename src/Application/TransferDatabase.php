<?php

namespace Omatech\EditoraTools\Application;

use Omatech\EditoraTools\Infrastructure\Repositories\MageAttributes;
use Omatech\EditoraTools\Infrastructure\Repositories\MageInstances;
use Omatech\EditoraTools\Infrastructure\Repositories\MageRelations;

class TransferDatabase
{
    public function make()
    {
        print_r("Importing Instances\n");
        $instancesIds = (new MageInstances())->import();
        print_r("\nImporting Attributes & Values\n");
        (new MageAttributes())->import($instancesIds);
        print_r("\nImporting Relations\n");
        (new MageRelations())->import($instancesIds);
    }
}
