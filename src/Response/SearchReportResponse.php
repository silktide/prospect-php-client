<?php

namespace Silktide\ProspectClient\Response;

use Countable;
use Iterator;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Entity\Report;

class SearchReportResponse extends AbstractResponse
{
    /**
     * @var array<Report>
     */
    private array $reports = [];

    public function __construct(ResponseInterface $httpResponse)
    {
        parent::__construct($httpResponse);
        foreach ($this->response["reports"] as $array) {
            $this->reports[] = Report::create($array);
        }
    }

    /**
     * @return array<Report>
     */
    public function getReports() : array
    {
        return $this->reports;
    }
}