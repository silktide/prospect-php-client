<?php

namespace Silktide\ProspectClient\Response;

class ReportSpellingsResponse extends AbstractResponse
{
    public function getSuccess(): bool
    {
        return isset($this->response['status']) && $this->response['status'] === 'success';
    }

    public function getErrorMessage(): string
    {
        return $this->response['error_message'] ?? '';
    }

    public function getWord(): array
    {
        return $this->response['word'] ?? [];
    }

}
