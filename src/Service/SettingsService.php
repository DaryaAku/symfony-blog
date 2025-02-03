<?php

namespace App\Service;

use App\Entity\Settings;
use App\Repository\SettingsRepository;

class SettingsService
{
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function getSetting(string $key): ?array
    {
        $setting = $this->settingsRepository->findByKey($key);
        return $setting ? $setting->getValue() : null;
    }

    public function setSetting(string $key, array $value): void
    {
        $setting = $this->settingsRepository->findByKey($key);
        if (!$setting) {
            $setting = new Settings();
            $setting->setKey($key);
        }
        $setting->setValue($value);
        $this->settingsRepository->save($setting);
    }
}
