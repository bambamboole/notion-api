<?php

namespace Bambamboole\NotionApi\Factories;

use Bambamboole\NotionApi\Enums\PropertyType;
use Bambamboole\NotionApi\Models\CollectionEntry;
use Bambamboole\NotionApi\Models\Properties\PropertyDeclaration;

class CollectionEntryFactory
{
    public function __construct(
        private PropertyFactory $propertyFactory = new PropertyFactory(),
        private BlockFactory    $blockFactory = new BlockFactory()
    )
    {
    }

    public function createFromCollectionData(string $id, array $schema, array $data): array
    {
        $allBlocks = $data['recordMap']['block'];
        $tableRows = array_map(
            fn (string $id) => $allBlocks[$id],
            $data['result']['reducerResults']['collection_group_results']['blockIds']
        );
        $tableData = array_filter(
            $tableRows,
            fn (array $row) => isset($row['value']['content']) && isset($row['value']['parent_id']) && $row['value']['parent_id'] === $id
        );

        $entries = [];
        foreach ($tableData as $row) {
            $rowId = $row['value']['id'];
            $properties = [];
            $title = null;
            foreach ($schema as $declaration) {
                /** @var PropertyDeclaration $declaration */
                if (!isset($row['value']['properties'][$declaration->id])) {
                    continue;
                }
                $property = $this->propertyFactory->createFromPayload($row['value']['properties'][$declaration->id], $declaration);
                if ($declaration->propertyType === PropertyType::TITLE) {
                    $title = $property->getValue();
                }
                $properties[] = $property;
            }

            $content = array_map(
                fn (string $id) => $this->blockFactory->createFromPayload($allBlocks[$id]),
                $row['value']['content']
            );

            $entries[] = new CollectionEntry($rowId, $title, $properties, $content);
        }

        return $entries;
    }
}
