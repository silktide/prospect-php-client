<?php

namespace Silktide\ProspectClient\Api\Request\Report;

use DateTime;
use Psr\Http\Message\UriInterface;
use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\Api\Request\AbstractRequest;
use Silktide\ProspectClient\ApiResponse\CreatedReportApiResponse;
use Silktide\ProspectClient\HTTP\HttpWrapper;

class CreateReportRequest extends AbstractRequest
{
    protected $properties = [];

    public function setUrl(string $url)
    {
        $this->properties["url"] = $url;
        return $this;
    }

    /** Pass values to set as one of your custom report fields. */
    public function setCustomField(string $key, string $value)
    {
        if ($key[0] !== "_") {
            $key = "_" . $key;
        }

        $this->properties[$key] = $value;
        return $this;
    }

    /** The analysis will not run if the website has already been tested after the supplied date. */
    public function setCheckForExisting(DateTime $since)
    {
        $this->properties["check_for_existing"] = $since->format(DateTime::ISO8601);
        return $this;
    }

    /**
     * Silktide Prospect will make a POST callback to this URL with the JSON report data.
     * @param string|UriInterface $uri
     */
    public function setCompletionWebhook(string $uri)
    {
        $this->properties["on_completion"] = $uri;
        return $this;
    }

    /** Business name, some checks will not work without this, e.g Local presence, Reviews. */
    public function setName(string $name)
    {
        $this->properties["name"] = $name;
        return $this;
    }

    /** Business phone number, some checks will not work without this, e.g Local presence, Reviews. */
    public function setPhone(string $phone)
    {
        $this->properties["phone"] = $phone;
        return $this;
    }

    /**
     * @param string $firstLine First line of business address, some checks will not work without this, e.g Local presence, Reviews
     * @param string $buildingNameOrNumber Building number, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $street Street, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $city City, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $stateOrCounty State or county, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $zipOrPostcode Zip or postcode, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $countryCode ISO 2 letter code – Country, enhances accuracy in some checks, e.g Local presence, Reviews
     */
    public function setAddress(
        string $firstLine = "",
        string $buildingNameOrNumber = "",
        string $street = "",
        string $city = "",
        string $stateOrCounty = "",
        string $zipOrPostcode = "",
        string $countryCode = ""
    ) {
        if($firstLine) {
            $this->properties["address"] = $firstLine;
        }
        if($buildingNameOrNumber) {
            $this->properties["number"] = $buildingNameOrNumber;
        }
        if($street) {
            $this->properties["street"] = $street;
        }
        if($city) {
            $this->properties["city"] = $city;
        }
        if ($stateOrCounty) {
            $this->properties["state"] = $stateOrCounty;
        }
        if($zipOrPostcode) {
            $this->properties["zip"] = $zipOrPostcode;
        }
        if($countryCode) {
            $this->properties["country_code"] = $countryCode;
        }
        return $this;
    }

    /** Latitude and longitude, enhances accuracy in some checks, e.g Local presence, Reviews. */
    public function setLatLng(float $lat, float $lon) {
        $this->properties["lat"] = $lat;
        $this->properties["lng"] = $lon;
        return $this;
    }

    /**
     * Products and services this business offers, some checks will not work without this, e.g Content keywords.
     * @param string...$products Individual products and services passed as variable arguments
     */
    public function setProducts(string...$products) {
        $this->properties["products"] = implode(",", $products);
        return $this;
    }

    /**
     * Locations served, some checks will not work without this, e.g Content keywords.
     * @param string...$locations Individual locations passed as variable arguments
     */
    public function setLocations(string...$locations) {
        $this->properties["locations"] = implode(",", $locations);
        return $this;
    }

    public function execute() : CreatedReportApiResponse
    {
        // Validate that nothing additional is nonsense here

        // Make the request
        $httpResponse = $this->httpWrapper->execute(
            ReportApi::API_PATH_PREFIX_SINGLE_REPORT,
            "POST",
            null,
            $this->properties
        );

        return new CreatedReportApiResponse($httpResponse);
    }

}