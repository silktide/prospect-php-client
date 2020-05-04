<?php
namespace Silktide\ProspectClient\ApiRequest;

use TypeError;
use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ApiResponse\FetchReportApiResponse;

class FetchReportApiRequest extends AbstractApiRequest
{
    protected string $apiPath = "report";
    protected string $apiMethod = "get";

    private string $id;

    public function execute(): FetchReportApiResponse
    {
        try {
            $this->apiPathSuffix = $this->id;
        }
        catch(TypeError $error) {
            throw new ReportIdNotSetException();
        }

        $httpResponse = $this->makeHttpRequest();

        switch($httpResponse->getStatusCode()) {
            case 202:
                throw new ReportStillRunningException($this->id);
        }

        return new FetchReportApiResponse($httpResponse);
    }

    public function setId(string $reportId)
    {
        $this->id = $reportId;
    }
}