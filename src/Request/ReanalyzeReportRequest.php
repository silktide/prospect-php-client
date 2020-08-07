<?php

namespace Silktide\ProspectClient\Request;

use Silktide\ProspectClient\Exception\Api\ReportNotFoundException;
use Silktide\ProspectClient\Http\HttpWrapper;
use Silktide\ProspectClient\Response\ReanalyzeReportResponse;

class ReanalyzeReportRequest extends AbstractRequest
{
    protected string $method = "POST";
    protected string $path = "report";

    private string $reportId;

    public function __construct(HttpWrapper $httpWrapper, string $reportId)
    {
        parent::__construct($httpWrapper);
        $this->reportId = $reportId;
    }

    public function getPath(): string
    {
        return $this->path . "/" . $this->reportId;
    }

    public function setCustomField(string $key, string $value): self
    {
        if ($key[0] !== "_") {
            $key = "_" . $key;
        }
        $this->body[$key] = $value;
        return $this;
    }

    /**
     * This URL will receive a POST callback with the JSON report data
     * @param string $url
     * @return $this
     */
    public function setCompletionWebhook(string $url): self
    {
        $this->body["on_completion"] = $url;
        return $this;
    }

    public function execute(): ReanalyzeReportResponse
    {
        $httpResponse = $this->httpWrapper->execute($this);
        $response = $httpResponse->getResponse();

        if ($httpResponse->getStatusCode() === 404) {
            throw new ReportNotFoundException($response["errorMessage"] ?? "Report not found");
        }

        return new ReanalyzeReportResponse($httpResponse->getResponse());
    }
}