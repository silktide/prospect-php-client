<?php

namespace Silktide\ProspectClient\UnitTest\ApiResponse;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class HttpResponseTestCase extends TestCase
{
    public function getMockHttpResponse(
        array $body = null,
        int $statusCode = 200
    ): ResponseInterface {
        $response = self::createMock(ResponseInterface::class);
        $response->method("getStatusCode")
            ->willReturn($statusCode);

        if (!is_null($body)) {
            $body = json_encode($body);
        }
        $response->method("getBody")
            ->willReturn($body);

        return $response;
    }
}