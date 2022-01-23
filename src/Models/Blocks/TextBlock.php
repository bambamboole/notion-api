<?php

namespace Bambamboole\NotionApi\Models\Blocks;

class TextBlock implements Block
{
    public function __construct(public readonly Paragraph $paragraph)
    {
    }
}
