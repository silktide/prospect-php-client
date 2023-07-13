<?php

namespace Silktide\ProspectClient\Response;

use Silktide\ProspectClient\Entity\DefinitionField;

class FetchDefinitionsResponse extends AbstractResponse
{
    /**
     * @return DefinitionField[]
     */
    public function getDefinitions(): array
    {
        $definitions = [];
        foreach ($this->response['fields'] as $field) {
            /**
             * @var $field array
             */

            $definitions[$field['id']] = DefinitionField::create(
                $field['id'],
                $field['label'],
                $field['description'],
                $field['type'],
                $field['scenarios'],
                $field
            );
        }

        return $definitions;
    }

    public function getRequestStatus() : string
    {
        return $this->response['request_status'];
    }
}
