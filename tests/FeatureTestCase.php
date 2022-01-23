<?php

namespace Bambamboole\NotionApi\Tests;

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FeatureTestCase extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        $repository = RepositoryBuilder::createWithDefaultAdapters()
            ->addAdapter(PutenvAdapter::class)
            ->immutable()
            ->make();
        Dotenv::create(
            $repository,
            dirname(__DIR__)
        )->safeLoad();

        if (!isset($_ENV['NOTION_TOKEN'])) {
            $this->markTestSkipped('Notion token needed for feature tests');
        }
        $stack = HandlerStack::create();
        if (isset($_ENV['RECORD_RESPONSES'])) {
            $stack->push(function (callable $handler) {
                return function (RequestInterface $request, array $options) use ($handler) {
                    $parts = explode('/', $request->getUri());
                    $resource = $parts[array_key_last($parts)] ?? 'undefined';
                    return $handler($request, $options)
                        ->then(function (ResponseInterface $response) use ($resource) {
                            if ($response->getStatusCode() === 200) {
                                $responseBody = $response->getBody()->getContents();
                                $fileName = sprintf(
                                    "%s/fixtures/responses/%s_%s.json",
                                    __DIR__,
                                    $resource,
                                    md5($responseBody)
                                );
                                if (!file_exists($fileName)) {
                                    file_put_contents($fileName, $responseBody);
                                }
                                $response->getBody()->rewind();
                            }
                            return $response;
                        });
                };
            });
        }

        $this->client = new Client(['handler' => $stack]);
    }
}
