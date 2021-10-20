<?php

namespace Omatech\EditoraTools\Infrastructure\Repositories;

use Ramsey\Uuid\Uuid;

class MageValues extends MageBase
{
    public function insert($id, $attributeId, $language, $value)
    {
        $query = $this->connection->prepare('
            INSERT INTO mage_values (`id`, `uuid`, `attribute_id`, `language`, `value`, `extra_data`)
            VALUES (:id, :uuid, :attributeId, :language, :value, :extraData)
        ');

        $query->bindValue('id', $id);
        $query->bindValue('uuid', Uuid::uuid4()->toString());
        $query->bindValue('attributeId', $attributeId);
        $query->bindValue('language', $this->conversion($language));
        $query->bindValue('value', $value);
        $query->bindValue('extraData', null);
        $query->execute();
    }
}
