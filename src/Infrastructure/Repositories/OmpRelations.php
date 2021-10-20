<?php

namespace Omatech\EditoraTools\Infrastructure\Repositories;

use Omatech\EditoraTools\Infrastructure\DB\DB;

class OmpRelations
{
    private $connection;

    public function __construct()
    {
        $this->connection = DB::connection('origin');
    }

    public function allInstanceRelations($instanceId)
    {
        $query = $this->connection->prepare('
            SELECT
                ompr.tag,
                ori.parent_inst_id,
                ori.child_inst_id
            FROM
                omp_relations ompr
            JOIN omp_relation_instances ori ON ompr.id = ori.rel_id
            WHERE ori.parent_inst_id = :parentInstanceId
            ORDER BY ori.parent_inst_id, ori.weight'
        );

        $query->bindValue('parentInstanceId', $instanceId);
        return $query->execute()->iterateAssociativeIndexed();
    }
}
