<?php

namespace Omatech\EditoraTools\Infrastructure\Repositories;

use Omatech\EditoraTools\Infrastructure\Utils\Utils;

class MageRelations extends MageBase
{
    private $oldRelations;

    public function __construct()
    {
        parent::__construct();
        $this->oldRelations = new OmpRelations();
    }

    public function import($instancesIds)
    {
        foreach($instancesIds as $oldId => $newId) {
            $relations = $this->oldRelations->allInstanceRelations($oldId);
            $order = 0;
            foreach($relations as $name => $data) {
                $this->insert(
                    Utils::getInstance()->slug($name),
                    $newId,
                    $instancesIds[$data['child_inst_id']],
                    $order++
                );
                echo ".";
            }
        }
    }

    private function insert($key, $parentInstanceId, $childInstanceId, $order)
    {
        $query = $this->connection->prepare('
            INSERT INTO mage_relations (`key`, `parent_instance_id`, `child_instance_id`, `order`)
            VALUES (:key, :parentInstanceId, :childInstanceId, :order)
        ');

        $query->bindValue('key', $key);
        $query->bindValue('parentInstanceId', $parentInstanceId);
        $query->bindValue('childInstanceId', $childInstanceId);
        $query->bindValue('order', $order);
        $query->execute();
    }
}
