<?php

namespace Bambamboole\NotionApi\Models\Blocks;

class NotSupportedBlock implements Block
{
    public function __construct(public readonly array $data)
    {
    }
}
