<?php

namespace Silktide\ProspectClient\Request;

use Silktide\ProspectClient\Exception\Api\ReportNotFoundException;
use Silktide\ProspectClient\Http\HttpWrapper;
use Silktide\ProspectClient\Response\FetchReportResponse;

class FetchReportRequest extends AbstractRequest
{
    protected string $path = "report";
    protected array $queryParams = [
        "categories" => "true"
    ];

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

    public function includeDatasets(bool $include = true): self
    {
        unset($this->queryParams["include_datasets"]);

        if ($include) {
            $this->queryParams["include_datasets"] = "true";
        }

        return $this;
    }

    public function execute(): FetchReportResponse
    {
        $httpResponse = $this->httpWrapper->execute($this);

        if ($httpResponse->getStatusCode() === 404) {
            throw new ReportNotFoundException($response["errorMessage"] ?? "Report not found");
        }

        return new FetchReportResponse($httpResponse->getResponse());
    }
}