<?php

namespace Bambamboole\NotionApi\Factories;

use Bambamboole\NotionApi\Models\Page;

class PageFactory
{
    public function __construct(
        private BlockFactory $blockFactory = new BlockFactory(),
        private ParagraphFactory $paragraphFactory = new ParagraphFactory()
    )
    {
    }

    public function createFromResponsePayload(string $response): Page
    {
        $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        $rawBlocks = $data['recordMap']['block'];
        $pageDetails = array_shift($rawBlocks);
        $title = $this->paragraphFactory->createFromPayload($pageDetails['value']['properties']['title'] ?? []);
        $blocks = array_map(fn (array $rawBLock) => $this->blockFactory->createFromPayload($rawBLock), $rawBlocks);

        return new Page($title, $blocks, $data);
    }
}
