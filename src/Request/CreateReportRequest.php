<?php
namespace Silktide\ProspectClient\Request;

use DateTimeInterface;
use Silktide\ProspectClient\Exception\Api\ReportAlreadyExistsException;
use Silktide\ProspectClient\Exception\Api\ReportUnprocessableException;
use Silktide\ProspectClient\Response\CreateReportResponse;

class CreateReportRequest extends AbstractRequest
{
    protected string $method = 'POST';
    protected string $path = 'report';

    public function setUrl(string $url): self
    {
        $this->body['url'] = $url;
        return $this;
    }

    /**
     * Pass values to set as one of your custom report fields.
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setCustomField(string $key, string $value): self
    {
        if ($key[0] !== '_') {
            $key = "_$key";
        }

        $this->body[$key] = $value;
        return $this;
    }

    /**
     * The analysis will not run if the website has already been tested after the supplied date
     *
     * @param DateTimeInterface $since
     * @return $this
     */
    public function setCheckForExisting(DateTimeInterface $since): self
    {
        $this->body['check_for_existing'] = $since->format(DateTimeInterface::ATOM);
        return $this;
    }

    /**
     * Prospect will make a POST callback to this URL with the JSON report data.
     *
     * @param string $uri
     * @return $this
     */
    public function setCompletionWebhook(string $uri): self
    {
        $this->body['on_completion'] = $uri;
        return $this;
    }

    /**
     * Business name, some checks will not work without this, e.g Local presence, Reviews.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->body['name'] = $name;
        return $this;
    }

    /**
     * Business phone number, some checks will not work without this, e.g Local presence, Reviews.
     * @param string $phone
     * @return $this
     */
    public function setPhone(string $phone): self
    {
        $this->body['phone'] = $phone;
        return $this;
    }

    /**
     * @param string $firstLine - First line of business address, some checks will not work without this, e.g Local presence, Reviews
     * @param string $buildingNameOrNumber - Building number, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $street - Street, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $city - City, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $stateOrCounty - State or county, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $zipOrPostcode - Zip or postcode, enhances accuracy in some checks, e.g Local presence, Reviews
     * @param string $countryCode - ISO 2 letter code – Country, enhances accuracy in some checks, e.g Local presence, Reviews
     * @return $this
     */
    public function setAddress(
        string $firstLine = '',
        string $buildingNameOrNumber = '',
        string $street = '',
        string $city = '',
        string $stateOrCounty = '',
        string $zipOrPostcode = '',
        string $countryCode = ''
    ): self {
        if ($firstLine) {
            $this->body['address'] = $firstLine;
        }
        if ($buildingNameOrNumber) {
            $this->body['number'] = $buildingNameOrNumber;
        }
        if ($street) {
            $this->body['street'] = $street;
        }
        if ($city) {
            $this->body['city'] = $city;
        }
        if ($stateOrCounty) {
            $this->body['state'] = $stateOrCounty;
        }
        if ($zipOrPostcode) {
            $this->body['zip'] = $zipOrPostcode;
        }
        if ($countryCode) {
            $this->body['country_code'] = $countryCode;
        }
        return $this;
    }

    /**
     * Latitude and longitude, enhances accuracy in some checks, e.g Local presence, Reviews.
     *
     * @param float $lat
     * @param float $lon
     * @return $this
     */
    public function setLatLng(float $lat, float $lon): self
    {
        $this->body['lat'] = $lat;
        $this->body['lng'] = $lon;
        return $this;
    }

    /**
     * Products and services this business offers, some checks will not work without this, e.g Content keywords.
     * @param string[] $products - Individual products and services passed as variable arguments
     * @return $this
     */
    public function setProducts(array $products = []): self
    {
        $this->body['products'] = implode(',', $products);
        return $this;
    }

    /**
     * Locations served, some checks will not work without this, e.g Content keywords.
     * @param string[] $locations - Individual locations passed as variable arguments
     * @return $this
     */
    public function setLocations(array $locations): self
    {
        $this->body['locations'] = implode(',', $locations);
        return $this;
    }

    public function execute(): CreateReportResponse
    {
        $httpResponse = $this->httpWrapper->execute($this);
        $response = $httpResponse->getResponse();

        switch ($httpResponse->getStatusCode()) {
            case 202:
                // Report has been requested and is now running
                break;

            case 303:
                // Recent results already exist for this business so it won't be retested
                $exception = new ReportAlreadyExistsException();
                $exception->setReportId($response['reportId']);
                $exception->setResolvedUrl($response['resolved_url'] ?? null);
                throw $exception;

            case 400:
            case 422:
                // Request was un-processable, usually because you’ve requested analysis on a website with a path, which we can’t currently accept.
                $exception = new ReportUnprocessableException($response['error_message'] ?? 'Unprocessable request');
                $exception->setIssue($response['issue'] ?? null);
                if (isset($response['url'])) {
                    $exception->setUrl($response['url']);
                    $exception->setUrlRecommended($response['recommendedUrl'] ?? false);
                }
                throw $exception;
        }

        return new CreateReportResponse($response);
    }
}
