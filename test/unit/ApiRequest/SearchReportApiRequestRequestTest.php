<?php

namespace Silktide\ProspectClient\UnitTest\ApiRequest;

use Silktide\ProspectClient\Request\SearchReportRequest;

class SearchReportApiRequestRequestTest extends HttpRequestTestCase
{
    public function testAddFilter()
    {
        $property = uniqid("property-");
        $operator = SearchReportRequest::FILTER_OPERATOR_EQUAL;
        $value = uniqid("value-");
        $httpWrapper = self::getSearchMockHttpWrapper(
            [
                "filter" => [
                    [
                        "operator" => $operator,
                        "property" => $property,
                        "targetValue" => $value,
                    ],
                ]
            ]
        );
        $sut = new SearchReportRequest($httpWrapper);
        $sut->addFilter($property, $operator, $value);
        $sut->execute();
    }

    public function testAddFilterMultiple()
    {
        $property1 = uniqid("property-");
        $operator1 = SearchReportRequest::FILTER_OPERATOR_EQUAL;
        $value1 = uniqid("value-");
        $property2 = uniqid("property-");
        $operator2 = SearchReportRequest::FILTER_OPERATOR_EQUAL;
        $value2 = uniqid("value-");
        $property3 = uniqid("property-");
        $operator3 = SearchReportRequest::FILTER_OPERATOR_EQUAL;
        $value3 = uniqid("value-");

        $httpWrapper = self::getSearchMockHttpWrapper(
            [
                "filter" => [
                    [
                        "operator" => $operator1,
                        "property" => $property1,
                        "targetValue" => $value1,
                    ],
                    [
                        "operator" => $operator2,
                        "property" => $property2,
                        "targetValue" => $value2,
                    ],
                    [
                        "operator" => $operator3,
                        "property" => $property3,
                        "targetValue" => $value3,
                    ],
                ]
            ]
        );
        $sut = new SearchReportRequest($httpWrapper);
        $sut->addFilter($property1, $operator1, $value1);
        $sut->addFilter($property2, $operator2, $value2);
        $sut->addFilter($property3, $operator3, $value3);
        $sut->execute();
    }

    public function testSetOrder()
    {
        $property = uniqid("property-");
        $httpWrapper = self::getSearchMockHttpWrapper(
            [
                "order" => [
                    $property => SearchReportRequest::ORDER_DIRECTION_ASCENDING,
                ]
            ]
        );
        $sut = new SearchReportRequest($httpWrapper);
        $sut->setOrder($property);
        $sut->execute();
    }

    public function testSetOrderDesc()
    {
        $property = uniqid("property-");
        $httpWrapper = self::getSearchMockHttpWrapper(
            [
                "order" => [
                    $property => SearchReportRequest::ORDER_DIRECTION_DESCENDING,
                ]
            ]
        );
        $sut = new SearchReportRequest($httpWrapper);
        $sut->setOrder($property, SearchReportRequest::ORDER_DIRECTION_DESCENDING);
        $sut->execute();
    }

    private function getSearchMockHttpWrapper(array $query = null, array $body = null)
    {
        return self::getMockHttpWrapper(
            "reports/",
            "GET",
            $query,
            $body
        );
    }
}