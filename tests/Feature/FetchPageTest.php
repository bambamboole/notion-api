<?php

namespace Bambamboole\NotionApi\Tests\Feature;

use Bambamboole\NotionApi\Clients\ApiV3Client;
use Bambamboole\NotionApi\Models\Page;
use Bambamboole\NotionApi\Tests\FeatureTestCase;
use GuzzleHttp\Client;

class FetchPageTest extends FeatureTestCase
{
    public function testItCanFetchANotionPage(): void
    {
        $apiClient = new ApiV3Client(new Client(),$_ENV['NOTION_TOKEN']);

        $page = $apiClient->getPage('27093cda5c1f428e9c3bdd030f7f16b5');

        self::assertInstanceOf(Page::class, $page);
    }
}
