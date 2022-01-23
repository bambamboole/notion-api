<?php

namespace Bambamboole\NotionApi\Models;

use Bambamboole\NotionApi\Models\Blocks\Block;
use Bambamboole\NotionApi\Models\Blocks\Paragraph;

class Page
{
    public function __construct(
        public readonly Paragraph $title,
        /** @var Block[] */
        public readonly array $blocks,
    )
    {
    }
}
