<?php

namespace Bambamboole\NotionApi\Factories;

use Bambamboole\NotionApi\Enums\PropertyType;
use Bambamboole\NotionApi\Models\Collection;
use Bambamboole\NotionApi\Models\Properties\PropertyDeclaration;

class CollectionFactory
{
    public function __construct(private ParagraphFactory $paragraphFactory = new ParagraphFactory())
    {
    }

    public function createFromResponsePayload(string $response): Collection
    {
        $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        $id = array_key_first($data['recordMap']['collection']);
        $name = $this->paragraphFactory->createFromPayload($data['recordMap']['collection'][$id]['value']['name']);
        $schema = array_map(
            fn (string $id, array $data) => new PropertyDeclaration($id, $data['name'], PropertyType::tryFrom($data['type'])),
            array_keys($data['recordMap']['collection'][$id]['value']['schema']),
            $data['recordMap']['collection'][$id]['value']['schema']
        );
        $tableRows = array_map(
            fn (string $id) => $data['recordMap']['block'][$id],
            $data['result']['reducerResults']['collection_group_results']['blockIds']
        );
        $tableData = array_filter($tableRows, fn (array $row) => $row['value']['properties']['parent_id'] ?? false === $id);

        return new Collection($id, $name, $schema);
    }
}
