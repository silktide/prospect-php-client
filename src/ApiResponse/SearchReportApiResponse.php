<?php

namespace Silktide\ProspectClient\ApiResponse;

use Countable;
use Iterator;
use Silktide\ProspectClient\Entity\Report;

class SearchReportApiResponse extends AbstractApiResponse implements Countable, Iterator
{
    /** @var int */
    private $iteratorKey = 0;
    /** @var string */
    private $iteratorKeyName = "report_id";

    public function setIteratorKeyName(string $name): void
    {
        $this->iteratorKeyName = $name;
    }

    public function getByIndex(int $index): ?Report
    {
        if (!isset($this->body["reports"][$index])) {
            return null;
        }

        return new Report($this->body["reports"][$index]);
    }

    public function rewind()
    {
        $this->iteratorKey = 0;
    }

    public function key()
    {
        return $this->body["reports"][$this->iteratorKey][$this->iteratorKeyName];
    }

    public function valid()
    {
        return isset($this->body["reports"][$this->iteratorKey]);
    }

    public function current(): Report
    {
        return new Report($this->body["reports"][$this->iteratorKey]);
    }

    public function next()
    {
        $this->iteratorKey++;
    }

    public function count()
    {
        return count($this->body["reports"]);
    }
}