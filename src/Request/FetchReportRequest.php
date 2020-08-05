<?php

namespace Silktide\ProspectClient\Request;

use Silktide\ProspectClient\Response\FetchReportResponse;

class FetchReportRequest extends AbstractRequest
{
    protected string $path = "report";
    protected array $queryParams = [
        "categories" => "true"
    ];

    private ?string $id;

    public function getPath(): string
    {
        return $this->path . "/" . $this->id;
    }

    public function execute(): FetchReportResponse
    {
        return new FetchReportResponse(
            $this->httpWrapper->execute($this)
        );
    }

    public function setId(string $reportId): self
    {
        $this->id = $reportId;
        return $this;
    }

    public function includeDatasets(bool $include = true): self
    {
        unset($this->queryParams["include_datasets"]);

        if ($include) {
            $this->queryParams["include_datasets"] = "true";
        }

        return $this;
    }
}