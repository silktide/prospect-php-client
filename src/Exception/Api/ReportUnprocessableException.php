<?php

namespace Silktide\ProspectClient\Exception\Api;

use Silktide\ProspectClient\Exception\ProspectClientException;

class ReportUnprocessableException extends ProspectClientException
{
    private ?string $issue;

    public function setIssue(?string $issue)
    {
        $this->issue = $issue;
    }

    public function getIssue()
    {
        return $this->issue;
    }
}