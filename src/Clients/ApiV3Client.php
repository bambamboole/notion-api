<?php

namespace Bambamboole\NotionApi\Clients;

use Bambamboole\NotionApi\Enums\V3ResourceType;
use Bambamboole\NotionApi\Factories\CollectionFactory;
use Bambamboole\NotionApi\Factories\PageFactory;
use Bambamboole\NotionApi\Models\Collection;
use Bambamboole\NotionApi\Models\Page;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Response;
use Ramsey\Uuid\Uuid;

/**
 * This client uses the private v3 Notion API, so please use at
 * your own risk. The token can be taken from the `token_v2`
 * cookie value while logged in to notion website
 */
class ApiV3Client
{
    private const BASE_URL = 'https://www.notion.so/api/v3/';

    public function __construct(
        private ClientInterface   $client,
        private string            $token,
        private PageFactory       $pageFactory = new PageFactory(),
        private CollectionFactory $collectionFactory = new CollectionFactory(),
    )
    {
    }

    public function getPage(string $id): Page
    {
        $body = [
            'pageId' => Uuid::fromString($id),
            'limit' => 100,
            'cursor' => ['stack' => []],
            'chunkNumber' => 0,
            'verticalColumns' => false,
        ];

        $response = $this->sendRequest(V3ResourceType::LOAD_PAGE_CHUNK, $body);

        return $this->pageFactory->createFromResponsePayload($response->getBody()->getContents());
    }

    public function getCollection(string $id): Collection
    {
        $page = $this->getPage($id);
        if (!isset($page->rawPageData['recordMap']['collection'])
            || !isset($page->rawPageData['recordMap']['collection_view'])) {
            throw new \InvalidArgumentException("Page with id {$id} does not have a table");
        }

        $body = [
            'collection' => [
                'id' => array_key_first($page->rawPageData['recordMap']['collection'])
            ],
            'collectionView' => [
                'id' => array_key_first($page->rawPageData['recordMap']['collection_view'])
            ],
            'loader' => [
                'type' => 'reducer',
                'reducers' => [
                    'collection_group_results' => [
                        'type' => 'results',
                        'limit' => 999,
                        'loadContentCover' => true
                    ],
                    'table:uncategorized:title:count' => [
                        'type' => 'aggregation',
                        'aggregation' => [
                            'property' => 'title',
                            'aggregator' => 'count'
                        ]
                    ]
                ],
                'searchQuery' => '',
                'userTimeZone' => 'Europe/Berlin'
            ]
        ];

        $response = $this->sendRequest(V3ResourceType::QUERY_COLLECTION, $body);

        return $this->collectionFactory->createFromResponsePayload($response->getBody()->getContents());
    }

    public function sendRequest(V3ResourceType $resourceType, array $body): Response
    {
        return $this->client->request(
            'POST',
            self::BASE_URL . $resourceType->value,
            [
                'cookies' => CookieJar::fromArray(['token_v2' => $this->token], 'www.notion.so'),
                'json' => $body
            ]
        );
    }
}
