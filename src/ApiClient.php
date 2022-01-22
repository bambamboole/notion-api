<?php

use GuzzleHttp\ClientInterface;

class ApiClient
{
    public function __construct(private ClientInterface $client, private string $token)
    {
    }


}
