<?php

namespace Bambamboole\NotionApi\Factories;

use Bambamboole\NotionApi\Models\Blocks\Block;
use Bambamboole\NotionApi\Models\Blocks\NotSupportedBlock;
use Bambamboole\NotionApi\Models\Blocks\TextBlock;

class BlockFactory
{
    public function __construct(private ParagraphFactory $paragraphFactory = new ParagraphFactory())
    {
    }

    public function createFromPayload(array $data): Block
    {
        return match ($data['value']['type']) {
            'text' => $this->createTextBlock($data),
            default => $this->createGenericBlock($data)
        };
    }

    private function createTextBlock(array $data): TextBlock
    {
        return new TextBlock($this->paragraphFactory->createFromPayload($data['value']['properties']['title'] ?? []));
    }

    private function createGenericBlock(array $data): NotSupportedBlock
    {
        return new NotSupportedBlock($data);
    }
}
