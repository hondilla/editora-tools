<?php

namespace Omatech\EditoraTools\Infrastructure\Repositories;

use Omatech\EditoraTools\Infrastructure\Utils\Utils;
use Ramsey\Uuid\Uuid;

class MageInstances extends MageBase
{
    private $oldInstances;

    public function __construct()
    {
        parent::__construct();
        $this->oldInstances = new OmpInstances();
    }

    public function import()
    {
        $this->clean();
        $mageInstancesIds = [];
        $instanceId = 0;
        foreach($this->oldInstances->allInstances() as $id => $instance) {
            $this->insert(++$instanceId, $instance);
            $mageInstancesIds[$id] = $instanceId;
            echo ".";
        }
        return $mageInstancesIds;
    }

    private function insert($id, $instance)
    {
        $query = $this->connection->prepare('
            INSERT INTO mage_instances (`id`, `uuid`, `class_key`, `key`, `status`, `start_publishing_date`, `end_publishing_date`)
            VALUES (:id, :uuid, :class_key, :key, :status, :start_publishing_date, :end_publishing_date)
        ');

        $query->bindValue('id', $id);
        $query->bindValue('uuid', Uuid::uuid4()->toString());
        $query->bindValue('class_key', Utils::getInstance()->slug($instance['name']));
        $query->bindValue('key', Utils::getInstance()->slug($instance['key_fields']));
        $query->bindValue('status', $this->conversion($instance['status']));
        $query->bindValue('start_publishing_date', $instance['publishing_begins']);
        $query->bindValue('end_publishing_date', $instance['publishing_ends'] == '' ? null : $instance['publishing_ends']);
        $query->executeQuery();
    }
}
