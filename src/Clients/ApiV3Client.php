<?php

namespace Bambamboole\NotionApi\Clients;

use Bambamboole\NotionApi\Enums\ResourceType;
use Bambamboole\NotionApi\Factories\PageFactory;
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
        private ClientInterface $client,
        private string $token,
        private PageFactory $pageFactory = new PageFactory()
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

        $response = $this->sendRequest(ResourceType::LOAD_PAGE_CHUNK, $body);

        return $this->pageFactory->createFromResponsePayload($response->getBody()->getContents());
    }

    public function sendRequest(ResourceType $resourceType,array $body): Response
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
