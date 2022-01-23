<?php

namespace Bambamboole\NotionApi\Factories;

use Bambamboole\NotionApi\Models\Blocks\Paragraph;
use Bambamboole\NotionApi\Models\Blocks\Span;

class ParagraphFactory
{
    public function createFromPayload(array $data): Paragraph
    {
        $spans = array_map(fn (array $span) => new Span($span[0], $span[1] ?? []), $data);

        return new Paragraph($spans);
    }
}
