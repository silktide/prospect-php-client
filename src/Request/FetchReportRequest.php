<?php

namespace Silktide\ProspectClient\Request;

use Silktide\ProspectClient\Exception\Api\ReportNotFoundException;
use Silktide\ProspectClient\Http\HttpWrapper;
use Silktide\ProspectClient\Response\FetchReportResponse;

class FetchReportRequest extends AbstractRequest
{
    protected string $path = 'report';
    protected array $queryParams = [];

    private string $reportId;

    public function __construct(HttpWrapper $httpWrapper, string $reportId)
    {
        parent::__construct($httpWrapper);
        $this->reportId = $reportId;
    }

    public function getPath(): string
    {
        return "$this->path/$this->reportId";
    }

    public function includeDatasets(): self
    {
        $this->queryParams['include_datasets'] = 1;
        return $this;
    }

    public function includeText(): self
    {
        $this->queryParams['include_text'] = 1;
        return $this;
    }

    public function includeCategories(): self
    {
        $this->queryParams['categories'] = 1;
        return $this;
    }

    public function includePercentiles(): self
    {
        $this->queryParams['percentiles'] = 1;
        return $this;
    }

    public function includeAvailableVersions(): self
    {
        $this->queryParams['available_versions'] = 1;
        return $this;
    }

    public function execute(): FetchReportResponse
    {
        $httpResponse = $this->httpWrapper->execute($this);

        if ($httpResponse->getStatusCode() === 404) {
            throw new ReportNotFoundException($response['error_message'] ?? 'Report not found');
        }

        return new FetchReportResponse($httpResponse->getResponse());
    }
}
