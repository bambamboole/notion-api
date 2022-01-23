<?php

namespace Bambamboole\NotionApi\Factories;

use Bambamboole\NotionApi\Enums\PropertyType;
use Bambamboole\NotionApi\Models\Collection;
use Bambamboole\NotionApi\Models\Properties\PropertyDeclaration;

class CollectionFactory
{
    public function __construct(
        private ParagraphFactory $paragraphFactory = new ParagraphFactory(),
        private CollectionEntryFactory $collectionEntryFactory = new CollectionEntryFactory()
    )
    {
    }

    public function createFromResponsePayload(string $response): Collection
    {
        $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        $id = array_key_first($data['recordMap']['collection']);
        $name = $this->paragraphFactory->createFromPayload($data['recordMap']['collection'][$id]['value']['name']);
        // Map the schema to typed property declarations
        $schema = array_map(
            fn (string $id, array $data) => new PropertyDeclaration($id, $data['name'], PropertyType::tryFrom($data['type'])),
            array_keys($data['recordMap']['collection'][$id]['value']['schema']),
            $data['recordMap']['collection'][$id]['value']['schema']
        );

        $entries = $this->collectionEntryFactory->createFromCollectionData($id, $schema, $data);

        return new Collection($id, $name, $schema, $entries);
    }
}
