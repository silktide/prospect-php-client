<?php

namespace Silktide\ProspectClient\ApiRequest;

use Silktide\ProspectClient\ApiResponse\SearchReportApiResponse;
use Silktide\ProspectClient\ApiResponse\AbstractApiResponse;

class SearchReportApiRequest extends AbstractApiRequest
{
    const FILTER_PROPERTY_DOMAIN = "domain";
    const FILTER_PROPERTY_OVERALL_SCORE = "overall_score";
    const FILTER_PROPERTY_REPORT_ID = "report_id";
    const FILTER_PROPERTY_REQUESTED_BY = "requested_by";
    const FILTER_PROPERTY_ANALYSIS_COUNTRY = "analysis_country";
    const FILTER_PROPERTY_REPORT_COMPLETED_AT = "report_completed_at";
    const FILTER_PROPERTY_DETECTED_NAME = "detected_name";
    const FILTER_PROPERTY_DETECTED_ADDRESS = "detected_address";
    const FILTER_PROPERTY_DETECTED_PHONE = "detected_phone";

    const FILTER_OPERATOR_EQUAL = "equal";
    const FILTER_OPERATOR_NOT_EQUAL = "not_equal";
    const FILTER_OPERATOR_MORE_THAN = "more_than";
    const FILTER_OPERATOR_LESS_THAN = "less_than";
    const FILTER_OPERATOR_STR_CONTAINS = "str_contains";

    const ORDER_DIRECTION_ASCENDING = "asc";
    const ORDER_DIRECTION_DESCENDING = "desc";

    const ORDER_PROPERTY_ID = "id";
    const ORDER_PROPERTY_USER_EMAIL = "user_email";
    const ORDER_PROPERTY_REPORT_HASH = "report_hash";
    const ORDER_PROPERTY_RUN_DATE = "run_date";
    const ORDER_PROPERTY_OVERALL_SCORE = "overall_score";
    const ORDER_PROPERTY_OVERALL = "overall";

    /** @var string */
    protected $apiPath = "reports";
    /** @var string */
    protected $apiMethod = "get";

    /** @var array */
    private $filter = [];
    /** @var array */
    private $orderBy = [];

    /** @return SearchReportApiResponse */
    public function execute(): AbstractApiResponse
    {
        if (!empty($this->orderBy)) {
            $this->query["order"] = json_encode($this->orderBy);
        }
        if (!empty($this->filter)) {
            $this->query["filter"] = json_encode($this->filter);
        }

        $httpResponse = $this->makeHttpRequest();
        return new SearchReportApiResponse($httpResponse);
    }

    public function addFilter(string $property, string $operator, string $value): self
    {
        $this->filter [] = [
            "operator" => $operator,
            "property" => $property,
            "targetValue" => $value,
        ];

        return $this;
    }

    public function setOrder(string $property, string $direction = self::ORDER_DIRECTION_ASCENDING): self
    {
        $this->orderBy = [
            $property => $direction,
        ];

        return $this;
    }
}