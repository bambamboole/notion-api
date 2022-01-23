<?php

namespace Bambamboole\NotionApi\Enums;

enum PropertyType: string
{
    case TEXT = 'text';
    case DATE = 'date';
    case MULTI_SELECT = 'multi_select';
}
