<?php

namespace FondOfImpala\Zed\WebUiSettingsQuoteConnector;

use FondOfImpala\Shared\WebUiSettingsQuoteConnector\WebUiSettingsQuoteConnectorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class WebUiSettingsQuoteConnectorConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getFallbackView(): string
    {
        return $this->get(WebUiSettingsQuoteConnectorConstants::CONFIG_WEB_UI_SETTINGS_QUOTE_CONNECTOR_VIEW_FALLBACK, WebUiSettingsQuoteConnectorConstants::CONFIG_WEB_UI_SETTINGS_QUOTE_CONNECTOR_VIEW_FALLBACK_DEFAULT);
    }
}
