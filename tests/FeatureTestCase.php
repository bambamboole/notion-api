<?php

namespace Bambamboole\NotionApi\Tests;

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use PHPUnit\Framework\TestCase;

class FeatureTestCase extends TestCase
{
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
    }
}
