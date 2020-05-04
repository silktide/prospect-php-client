<?php

namespace Silktide\ProspectClient\ApiRequest;

use Silktide\ProspectClient\ApiResponse\ReanalyzeReportApiResponse;
use TypeError;

class ReanalyzeReportApiRequest extends AbstractApiRequest
{
    protected string $apiPath = "/report";
    protected string $apiMethod = "post";

    private string $id;

    public function execute(): ReanalyzeReportApiResponse
    {
        try {
            $this->apiPathSuffix = $this->id;
        }
        catch(TypeError $error) {
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