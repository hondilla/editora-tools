<?php

namespace Omatech\EditoraTools\Infrastructure\Repositories;

use Omatech\EditoraTools\Infrastructure\DB\DB;

abstract class MageBase
{
    public $connection;

    public function __construct()
    {
        $this->connection = DB::connection('destination');
    }

    protected function clean()
    {
        $this->connection->executeQuery('TRUNCATE TABLE mage_relations');
        $this->connection->executeQuery('TRUNCATE TABLE mage_values');
        $this->connection->executeQuery('TRUNCATE TABLE mage_attributes');
        $this->connection->executeQuery('TRUNCATE TABLE mage_instances');
    }

    protected function conversion($origin)
    {
        $conversions = [
            'ALL' => '*',
            'es' => 'es',
            'it' => 'it',
            'pt' => 'pt',
            'de' => 'de',
            'en' => 'en',
            'fr' => 'fr',
            'O' => 'published',
            'P' => 'pending'
        ];
        return $conversions[$origin];
    }
}
