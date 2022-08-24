<?php

namespace Silktide\ProspectClient\Response;

use Silktide\ProspectClient\Entity\ReportSetting;

class ReportSettingsResponse extends AbstractResponse
{
    /**
     * @return ReportSetting[]
     */
    public function getSettings(): array
    {
        $settings = [];
        foreach ($this->response['settings'] ?? [] as $id => $setting) {
            $settings[] = ReportSetting::create($id, $setting['type'], $setting['value']);
        }
        return $settings;
    }

    public function getSetting(string $id): ReportSetting
    {
        if (empty($this->response['settings'][$id])) {
            throw new \OutOfBoundsException('No such setting '.$id);
        }

        $setting = $this->response['settings'][$id];

        return ReportSetting::create($id, $setting['type'], $setting['value']);
    }
}
