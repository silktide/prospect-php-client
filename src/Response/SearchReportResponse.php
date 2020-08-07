<?php

namespace Silktide\ProspectClient\Response;

use Countable;
use Iterator;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Entity\Report;

class SearchReportResponse extends AbstractResponse
{
    /**
     * @return Report[]
     */
    public function getReports() : array
    {
        $reports = [];
        foreach ($this->response["reports"] as $array) {
            $reports[] = Report::create($array);
        }
        return $reports;
    }
}