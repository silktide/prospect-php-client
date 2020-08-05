<?php

namespace Silktide\ProspectClient\UnitTest\ApiRequest;

use DateTime;
use DateTimeInterface;
use Silktide\ProspectClient\Request\CreateReportRequest;

class CreateReportApiRequestRequestTest extends HttpRequestTestCase
{
    public function testSetUrl()
    {
        $url = uniqid("http://example.silktide.com/");
        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "url" => $url,
            ]
        );

        $sut = new CreateReportRequest($httpWrapper);
        $sut->setUrl($url);
        $sut->execute();
    }

    public function testSetCustomField()
    {
        $key = uniqid("key-");
        $value = uniqid("value-");

        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "_$key" => $value,
            ]
        );

        $sut = new CreateReportRequest($httpWrapper);
        $sut->setCustomField($key, $value);
        $sut->execute();
    }

    public function testSetCheckForExisting()
    {
        $dateTime = new DateTime("-10 minutes");

        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "check_for_existing" => $dateTime->format(DateTimeInterface::ATOM),
            ]
        );

        $sut = new CreateReportRequest($httpWrapper);
        $sut->setCheckForExisting($dateTime);
        $sut->execute();
    }

    public function testSetCompletionWebhook()
    {
        $uri = uniqid("https://example.silktide.com/completion-");

        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "on_completion" => $uri,
            ]
        );

        $sut = new CreateReportRequest($httpWrapper);
        $sut->setCompletionWebhook($uri);
        $sut->execute();
    }

    public function testSetName()
    {
        $name = uniqid();
        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "name" => $name
            ]
        );
        $sut = new CreateReportRequest($httpWrapper);
        $sut->setName($name);
        $sut->execute();
    }

    public function testSetPhone()
    {
        $phone = uniqid();
        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "phone" => $phone,
            ]
        );
        $sut = new CreateReportRequest($httpWrapper);
        $sut->setPhone($phone);
        $sut->execute();
    }

    public function testSetAddress()
    {
        $address = [
            "address" => uniqid("first-line-"),
            "number" => rand(1, 999),
            "street" => uniqid("street-"),
            "city" => uniqid("city-"),
            "state" => uniqid("state-"),
            "zip" => uniqid("zip-"),
            "country_code" => uniqid("country-code-"),
        ];
        $httpWrapper = self::getCreateMockHttpWrapper($address);
        $sut = new CreateReportRequest($httpWrapper);
        $sut->setAddress(
            $address["address"],
            $address["number"],
            $address["street"],
            $address["city"],
            $address["state"],
            $address["zip"],
            $address["country_code"]
        );
        $sut->execute();
    }

    public function testSetLatLng()
    {
        $lat = rand(-90, 90);
        $lng = rand(-180, 180);
        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "lat" => $lat,
                "lng" => $lng,
            ]
        );
        $sut = new CreateReportRequest($httpWrapper);
        $sut->setLatLng($lat, $lng);
        $sut->execute();
    }

    public function testSetProducts()
    {
        $products = [];
        for ($i = 0, $num = rand(3, 50); $i < $num; $i++) {
            $products [] = uniqid("product-");
        }

        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "products" => implode(",", $products),
            ]
        );
        $sut = new CreateReportRequest($httpWrapper);
        $sut->setProducts($products);
        $sut->execute();
    }

    public function testSetLocations()
    {
        $locations = [];
        for ($i = 0, $num = rand(3, 50); $i < $num; $i++) {
            $locations [] = uniqid("location-");
        }

        $httpWrapper = self::getCreateMockHttpWrapper(
            [
                "locations" => implode(",", $locations),
            ]
        );
        $sut = new CreateReportRequest($httpWrapper);
        $sut->setLocations(...$locations);
        $sut->execute();
    }

    private function getCreateMockHttpWrapper(array $body)
    {
        return self::getMockHttpWrapper(
            "report/",
            "POST",
            null,
            $body
        );
    }
}