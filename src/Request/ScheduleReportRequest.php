<?php

namespace Silktide\ProspectClient\Request;

use DateTime;
use Silktide\ProspectClient\Exception\Api\ReportUnprocessableException;
use Silktide\ProspectClient\Response\ScheduleReportResponse;

class ScheduleReportRequest extends AbstractRequest
{
    protected string $method = 'POST';
    protected string $path = 'report-scheduler';

    public function setRunDate(DateTime $date): self
    {
        $this->body['run_date'] = $date->format('Y-m-dTH:i:s');
        return $this;
    }

    public function setRepeatRuns(bool $repeatRuns): self
    {
        $this->body['repeat_runs'] = $repeatRuns;
        return $this;
    }

    public function setFrequency(int $frequency): self
    {
        $this->body['frequency'] = $frequency;
        return $this;
    }

    public function setFrequencyUnit(string $frequencyUnit): self
    {
        $this->body['frequency_unit'] = $frequencyUnit;
        return $this;
    }

    public function setStopAutomatically(bool $stopAutomatically): self
    {
        $this->body['stop_automatically'] = $stopAutomatically;
        return $this;
    }

    public function setRepeatsRemaining(int $repeatsRemaining): self
    {
        $this->body['repeats_remaining'] = $repeatsRemaining;
        return $this;
    }

    public function setNotifyContacts(bool $notifyContacts): self
    {
        $this->body['notify_contacts'] = $notifyContacts;
        return $this;
    }

    /**
     * @param string[] $notificationEmails
     * @return self
     */
    public function setNotificationEmails(array $notificationEmails): self
    {
        $this->body['notification_emails'] = $notificationEmails;
        return $this;
    }

    public function setNotificationMedium(string $notificationMedium): self
    {
        $this->body['notification_medium'] = $notificationMedium;
        return $this;
    }

    public function execute(): ScheduleReportResponse
    {
        $httpResponse = $this->httpWrapper->execute($this);
        $response = $httpResponse->getResponse();

        switch ($httpResponse->getStatusCode()) {
            case 200:
                // Report has been requested and is now running
                break;

            case 400:
                // Request was un-processable.
                $exception = new ReportUnprocessableException($response['error_message'] ?? 'Unprocessable request');
                $exception->setIssue($response['issue'] ?? null);
                if (isset($response['url'])) {
                    $exception->setUrl($response['url']);
                    $exception->setUrlRecommended($response['recommendedUrl'] ?? false);
                }
                throw $exception;
        }

        return new ScheduleReportResponse($response);
    }
}
