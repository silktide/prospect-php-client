<?php
namespace Silktide\ProspectClient\ApiRequest;

use Error;
use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ApiResponse\FetchReportApiResponse;
use Silktide\ProspectClient\ApiResponse\AbstractApiResponse;
use TypeError;

class FetchReportApiRequest extends AbstractApiRequest
{
    /** @var string */
    protected $apiPath = "report";
    /** @var string */
    protected $apiMethod = "get";

    /** @var */
    private $id;

    /** @return FetchReportApiResponse */
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

        switch ($httpResponse->getStatusCode()) {
            case 202:
                throw new ReportStillRunningException($this->id);
        }

        return new FetchReportApiResponse($httpResponse);
    }

    public function setId(string $reportId): void
    {
        $this->id = $reportId;
    }
}