<?php

namespace Silktide\ProspectClient\Exception\Api;

use Silktide\ProspectClient\Exception\ProspectClientException;

class ReportUnprocessableException extends ProspectClientException
{
    private ?string $issue = null;

    public function setIssue(?string $issue) : void
    {
        $this->issue = $issue;
    }

    public function getIssue() : ?string
    {
        return $this->issue;
    }
}