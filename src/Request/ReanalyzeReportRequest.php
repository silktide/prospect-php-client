<?php

namespace Silktide\ProspectClient\Request;

use Silktide\ProspectClient\Response\ReanalyzeReportResponse;

class ReanalyzeReportRequest extends AbstractRequest
{
    protected string $path = "report";
    protected string $method = "post";

    private string $id;

    public function execute(): ReanalyzeReportResponse
    {
        return new ReanalyzeReportResponse(
            $this->httpWrapper->execute($this)
        );
    }

    public function getPath(): string
    {
        return $this->path . "/" . $this->id;
    }

    public function setId(string $reportId): self
    {
        $this->id = $reportId;
        return $this;
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
}