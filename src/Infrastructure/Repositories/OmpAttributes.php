<?php

namespace Omatech\EditoraTools\Infrastructure\Repositories;

use Doctrine\DBAL\ParameterType;
use Omatech\EditoraTools\Infrastructure\DB\DB;

class OmpAttributes
{
    private $connection;

    public function __construct()
    {
        $this->connection = DB::connection('origin');
    }

    public function attributesOfInstance($id)
    {
        $query = $this->connection->prepare('
            SELECT oa.tag, oa.language, ov.text_val
            FROM omp_attributes oa
            JOIN omp_class_attributes oca ON oca.atri_id = oa.id
            JOIN omp_instances oi ON oi.class_id = oca.class_id
            JOIN omp_values ov ON ov.inst_id = oi.id AND ov.atri_id = oa.id
            WHERE oi.id = :id'
        );
        $query->bindValue('id', $id, ParameterType::INTEGER);
        return $query->executeQuery()->fetchAllAssociative();
    }
}
