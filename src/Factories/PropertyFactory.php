<?php

namespace Bambamboole\NotionApi\Factories;

use Bambamboole\NotionApi\Enums\PropertyType;
use Bambamboole\NotionApi\Models\Properties\DateProperty;
use Bambamboole\NotionApi\Models\Properties\MultiSelectProperty;
use Bambamboole\NotionApi\Models\Properties\Property;
use Bambamboole\NotionApi\Models\Properties\PropertyDeclaration;
use Bambamboole\NotionApi\Models\Properties\TextProperty;

class PropertyFactory
{
    public function __construct(private ParagraphFactory $paragraphFactory = new ParagraphFactory())
    {
    }

    public function createFromPayload(array $data, PropertyDeclaration $propertyDeclaration): Property
    {
        return match ($propertyDeclaration->propertyType) {
            PropertyType::TITLE, PropertyType::TEXT => $this->createTextProperty($propertyDeclaration, $data),
            PropertyType::DATE => $this->createDateProperty($propertyDeclaration, $data),
            PropertyType::MULTI_SELECT => $this->createMultiSelectProperty($propertyDeclaration, $data),
        };
    }

    private function createTextProperty(PropertyDeclaration $declaration, array $data): TextProperty
    {
        return new TextProperty($declaration->id, $declaration->name, $this->paragraphFactory->createFromPayload($data));
    }

    private function createDateProperty(PropertyDeclaration $declaration, array $data): DateProperty
    {
        return new DateProperty($declaration->id, $declaration->name, $data[0][1][0][1]['start_date']);
    }

    private function createMultiSelectProperty(PropertyDeclaration $declaration, array $data): MultiSelectProperty
    {
        return new MultiSelectProperty($declaration->id, $declaration->name, explode(',', $data[0][0]));
    }
}
