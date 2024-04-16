<?php

namespace FondOfImpala\Zed\WebUiSettings;

use FondOfImpala\Shared\WebUiSettings\WebUiSettingsConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class WebUiSettingsConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getFallbackView(): string
    {
        return $this->get(WebUiSettingsConstants::CONFIG_WEB_UI_SETTINGS_VIEW_FALLBACK, WebUiSettingsConstants::CONFIG_WEB_UI_SETTINGS_VIEW_FALLBACK_DEFAULT);
    }
}
