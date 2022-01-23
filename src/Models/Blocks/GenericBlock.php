<?php

namespace Bambamboole\NotionApi\Models\Blocks;

class GenericBlock implements Block
{
    public function __construct(public readonly array $data)
    {
    }
}
