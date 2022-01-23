<?php

namespace Bambamboole\NotionApi\Tests\Unit;

use Bambamboole\NotionApi\ApiClient;
use Bambamboole\NotionApi\Enums\ResourceType;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiClientTest extends TestCase
{
    public function testItAutomaticallySetsTheAuthenticationCookie(): void
    {
        $clientMock = $this->createMock(ClientInterface::class);
        $clientMock->expects(self::once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->anything(),
                $this->callback(
                    fn (array $subject) => $subject['cookies'] instanceof CookieJar
                        && $subject['cookies']->getCookieByName('token_v2')->getValue() === 'test_token'
                )
            )
            ->willReturn(new Response());
        $client = new ApiClient($clientMock, 'test_token');

        $client->sendRequest(ResourceType::LOAD_PAGE_CHUNK, []);
    }
}
