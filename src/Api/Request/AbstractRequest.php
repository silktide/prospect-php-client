<?php


namespace Silktide\ProspectClient\Api\Request;


use Silktide\ProspectClient\HTTP\HttpWrapper;

abstract class AbstractRequest
{
    protected $httpWrapper;

    public function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }

    abstract function execute();

}