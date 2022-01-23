<?php

namespace Bambamboole\NotionApi\Models\Blocks;

class Paragraph
{
    public function __construct(
        /** @var Span[] */
        public readonly array $spans
    )
    {
    }
}
