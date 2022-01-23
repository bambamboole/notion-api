<?php

namespace Bambamboole\NotionApi\Tests\Feature;

use Bambamboole\NotionApi\Clients\ApiV3Client;
use Bambamboole\NotionApi\Models\Collection;
use Bambamboole\NotionApi\Tests\FeatureTestCase;
use GuzzleHttp\Client;

class FetchCollectionTest extends FeatureTestCase
{
    public function testItCanFetchANotionPage(): void
    {
        $apiClient = new ApiV3Client($this->client, $_ENV['NOTION_TOKEN']);

        $collection = $apiClient->getCollection('4c960f6f57ce43e9b6b44387e05b8d3f');

        self::assertInstanceOf(Collection::class, $collection);
    }
}
