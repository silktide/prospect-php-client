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

    /**
     * Pass values to set as one of your custom report fields.
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
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
     * @return $this
     */
    public function setCompletionWebhook(string $uri): self
    {
        $this->body["on_completion"] = $uri;
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