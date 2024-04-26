<?php

namespace FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business;

use FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business\Expander\QuoteExpander;
use FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business\Expander\QuoteExpanderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\WebUiSettingsQuoteConnector\WebUiSettingsQuoteConnectorConfig getConfig()
 */
class WebUiSettingsQuoteConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business\Expander\QuoteExpanderInterface
     */
    public function createQuoteExpander(): QuoteExpanderInterface
    {
        return new QuoteExpander(
            $this->getConfig(),
        );
    }
}
