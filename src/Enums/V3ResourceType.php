<?php

namespace Bambamboole\NotionApi\Enums;

enum V3ResourceType: string
{
    case LOAD_PAGE_CHUNK = 'loadPageChunk';
    case QUERY_COLLECTION = 'queryCollection';
}
