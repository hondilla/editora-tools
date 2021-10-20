<?php

namespace Omatech\EditoraTools\Infrastructure\Repositories;

use Omatech\EditoraTools\Infrastructure\DB\DB;

class OmpInstances
{
    private $connection;

    public function __construct()
    {
        $this->connection = DB::connection('origin');
    }

    public function allInstances()
    {
        return $this->connection->iterateAssociativeIndexed('
            SELECT
                oi.id,
                oc.name,
                oi.key_fields,
                oi.status,
                oi.publishing_begins,
                oi.publishing_ends
            FROM omp_instances oi
            JOIN omp_classes oc ON oi.class_id = oc.id'
        );
    }
}
