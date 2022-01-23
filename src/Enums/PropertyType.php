<?php

namespace Bambamboole\NotionApi\Enums;

enum PropertyType: string
{
    case TEXT = 'text';
    case TITLE = 'title';
    case DATE = 'date';
    case MULTI_SELECT = 'multi_select';
}
