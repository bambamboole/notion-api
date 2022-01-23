<?php

namespace Bambamboole\NotionApi\Models\Blocks;

class Span
{
    public function __construct(public readonly string $text, public readonly array $attributes = [])
    {
    }
}
