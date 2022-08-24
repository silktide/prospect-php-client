<?php

namespace Silktide\ProspectClient\Request;

use Silktide\ProspectClient\Exception\Api\ReportNotFoundException;
use Silktide\ProspectClient\Http\HttpWrapper;
use Silktide\ProspectClient\Response\AbstractResponse;
use Silktide\ProspectClient\Response\ReportSettingsResponse;

class ReportSettingsRequest extends AbstractRequest
{
    protected string $path = 'report-settings';
    protected string $reportId;

    public function __construct(HttpWrapper $httpWrapper, string $reportId)
    {
        parent::__construct($httpWrapper);
        $this->reportId = $reportId;
    }

    public function persistSetting(string $name, $value): self
    {
        $this->method = 'PUT';
        $this->body[$name] = $value;

        return $this;
    }

    public function getPath(): string
    {
        return "$this->path/$this->reportId";
    }

    public function execute(): ReportSettingsResponse
    {
        $httpResponse = $this->httpWrapper->execute($this);

        if ($httpResponse->getStatusCode() === 404) {
            throw new ReportNotFoundException($response['error_message'] ?? 'Report not found');
        }

        return new ReportSettingsResponse($httpResponse->getResponse());
    }
}