<?php

namespace Silktide\ProspectClient\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface as HttpResponse;
use Silktide\ProspectClient\Data\BodyData;
use Silktide\ProspectClient\Data\QueryStringData;
use Silktide\ProspectClient\HTTP\HttpWrapper;

abstract class AbstractApi
{
    protected $httpWrapper;

    public function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }
}