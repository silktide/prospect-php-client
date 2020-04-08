<?php

namespace Silktide\ProspectClient\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Silktide\ProspectClient\Data\BodyData;
use Silktide\ProspectClient\Data\QueryStringData;

abstract class AbstractApi
{
    const BASE_URI = "https://api.prospect.silktide.com/api/v1";
    const API_SUFFIX = "/";

    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new HttpClient();
    }

    protected function callApi(
        string $path,
        string $method = "get",
        QueryStringData $query = null,
        BodyData $body = null
    ): HttpResponse {
    }
}