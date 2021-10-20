<?php
namespace Omatech\EditoraTools\Infrastructure\Repositories;

use Omatech\EditoraTools\Infrastructure\Utils\Utils;

class MageAttributes extends MageBase
{
    private $oldAttributes;
    private $mageValues;

    public function __construct()
    {
        parent::__construct();
        $this->oldAttributes = new OmpAttributes();
        $this->mageValues = new MageValues();
    }

    public function import($instanceIds)
    {
        $attributeId = 0;
        $valueId = 0;

        foreach($instanceIds as $oldId => $newId) {
            $attributesProcessed = [];
            foreach($this->oldAttributes->attributesOfInstance($oldId) as $attribute) {
                if(!isset($attributesProcessed[$attribute['tag']])) {
                    $attributesProcessed[$attribute['tag']] = ++$attributeId;
                    $this->insert($newId, $attributesProcessed[$attribute['tag']], $attribute['tag']);
                }

                $this->mageValues->insert(
                    ++$valueId,
                    $attributesProcessed[$attribute['tag']],
                    $attribute['language'],
                    $attribute['text_val']
                );
                echo ".";
            }
        }
    }

    private function insert($instanceId, $attributeId, $key)
    {
        $query = $this->connection->prepare('
            INSERT INTO mage_attributes (`id`, `instance_id`, `parent_id`, `key`)
            VALUES (:id, :instanceId, :parentId, :key)
        ');
        $query->bindValue('id', $attributeId);
        $query->bindValue('instanceId', $instanceId);
        $query->bindValue('parentId', null);
        $query->bindValue('key', Utils::getInstance()->slug($key));
        $query->execute();
    }
}
