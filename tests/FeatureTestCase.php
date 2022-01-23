<?php

namespace Bambamboole\NotionApi\Tests;

use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;
use PHPUnit\Framework\TestCase;

class FeatureTestCase extends TestCase
{
    protected function setUp(): void
    {
        Dotenv::create(
            RepositoryBuilder::createWithDefaultAdapters()->immutable()->make(),
            dirname(__DIR__)
        )->safeLoad();
    }
}
