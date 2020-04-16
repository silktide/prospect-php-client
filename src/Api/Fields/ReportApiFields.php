<?php

namespace Silktide\ProspectClient\Api\Fields;

use DateTime;
use Psr\Http\Message\UriInterface;

class ReportApiFields extends AbstractApiFields
{
    /** Pass values to set as one of your custom report fields. */
    public function customField(string $key, string $value): void
    {
        if ($key[0] !== "_") {
            $key = "_" . $key;
        }

        $this->keyValuePairs[$key] = $value;
    }

    /** The analysis will not run if the website has already been tested after the supplied date. */
    public function checkForExisting(DateTime $since): void
    {
        $this->keyValuePairs["check_for_existing"] = $since->format(DateTime::ISO8601);
    }

    /**
     * Silktide Prospect will make a POST callback to this URL with the JSON report data.
     * @param string|UriInterface $uri
     */
    public function completionWebhook(string $uri): void
    {
        $this->keyValuePairs["on_completion"] = $uri;
    }

    /** Business name, some checks will not work without this, e.g Local presence, Reviews. */
    public function name(string $name): void
    {
        $this->keyValuePairs["name"] = $name;
    }

    /** Business phone number, some checks will not work without this, e.g Local presence, Reviews. */
    public function phone(string $phone): void
    {
        $this->keyValuePairs["phone"] = $phone;
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
    public function address(
        string $firstLine = "",
        string $buildingNameOrNumber = "",
        string $street = "",
        string $city = "",
        string $stateOrCounty = "",
        string $zipOrPostcode = "",
        string $countryCode = ""
    ): void {
        if($firstLine) {
            $this->keyValuePairs["address"] = $firstLine;
        }
        if($buildingNameOrNumber) {
            $this->keyValuePairs["number"] = $buildingNameOrNumber;
        }
        if($street) {
            $this->keyValuePairs["street"] = $street;
        }
        if($city) {
            $this->keyValuePairs["city"] = $city;
        }
        if ($stateOrCounty) {
            $this->keyValuePairs["state"] = $stateOrCounty;
        }
        if($zipOrPostcode) {
            $this->keyValuePairs["zip"] = $zipOrPostcode;
        }
        if($countryCode) {
            $this->keyValuePairs["country_code"] = $countryCode;
        }
    }

    /** Latitude and longitude, enhances accuracy in some checks, e.g Local presence, Reviews. */
    public function latLng(float $lat, float $lon): void {
        $this->keyValuePairs["lat"] = $lat;
        $this->keyValuePairs["lng"] = $lon;
    }

    /**
     * Products and services this business offers, some checks will not work without this, e.g Content keywords.
     * @param string...$products Individual products and services passed as variable arguments
     */
    public function products(string...$products): void {
        $this->keyValuePairs["products"] = implode(",", $products);
    }

    /**
     * Locations served, some checks will not work without this, e.g Content keywords.
     * @param string...$locations Individual locations passed as variable arguments
     */
    public function locations(string...$locations): void {
        $this->keyValuePairs["locations"] = implode(",", $locations);
    }
}