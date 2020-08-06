<?php


namespace Silktide\ProspectClient\Http;


use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Exception\Api\InvalidServerResponseException;

class HttpResponse
{
    protected ResponseInterface $httpResponse;
    protected array $response;

    public function __construct(ResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;

        $response = json_decode($httpResponse->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($response)) {
            throw new InvalidServerResponseException("Prospect server error: invalid response");
        }

        if ($this->httpResponse->getStatusCode() === 500) {
            $message = "Prospect server error";
            if (isset($response["errorMessage"])) {
                $message .= ":" . $response["errorMessage"];
            }
            throw new InvalidServerResponseException($message);
        }

        $this->response = $response;
    }

    public function getStatusCode() : int
    {
        return $this->httpResponse->getStatusCode();
    }

    public function getResponse() : array
    {
        return $this->response;
    }
}