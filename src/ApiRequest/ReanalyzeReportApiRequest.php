<?php

namespace Silktide\ProspectClient\ApiRequest;

use Error;
use Silktide\ProspectClient\ApiResponse\ReanalyzeReportApiResponse;
use Silktide\ProspectClient\ApiResponse\AbstractApiResponse;
use TypeError;

class ReanalyzeReportApiRequest extends AbstractApiRequest
{
    /** @var string */
    protected $apiPath = "/report";
    /** @var string */
    protected $apiMethod = "post";

    /** @var string */
    private $id;

    /** @return ReanalyzeReportApiResponse */
    public function execute(): AbstractApiResponse
    {
        try {
            $this->apiPathSuffix = $this->id;
            // TODO: Temporary fix while PHP 7.2 is a requirement:
            if(!$this->id) {
                throw new TypeError("ID is not yet set");
            }
        } catch (Error $error) {
            throw new ReportIdNotSetException();
        }

        $httpResponse = $this->makeHttpRequest();
        return new ReanalyzeReportApiResponse($httpResponse);
    }

    public function setId(string $reportId)
    {
        $this->id = $reportId;
    }

    /** Pass values to set as one of your custom report fields. */
    public function setCustomField(string $key, string $value): self
    {
        if ($key[0] !== "_") {
            $key = "_" . $key;
        }
        $this->body[$key] = $value;
        return $this;
    }

    /**
     * Silktide Prospect will make a POST callback to this URL with the JSON report data.
     * @param string $uri
     */
    public function setCompletionWebhook(string $uri): self
    {
        $this->body["on_completion"] = $uri;
        return $this;
    }
}