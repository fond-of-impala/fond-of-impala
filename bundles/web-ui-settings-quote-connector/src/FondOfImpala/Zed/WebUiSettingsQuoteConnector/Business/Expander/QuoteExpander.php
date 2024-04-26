<?php

namespace FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business\Expander;

use FondOfImpala\Zed\WebUiSettingsQuoteConnector\WebUiSettingsQuoteConnectorConfig;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    protected WebUiSettingsQuoteConnectorConfig $config;

    /**
     * @param \FondOfImpala\Zed\WebUiSettingsQuoteConnector\WebUiSettingsQuoteConnectorConfig $config
     */
    public function __construct(WebUiSettingsQuoteConnectorConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        if ($quoteTransfer->getView() !== null) {
            return $quoteTransfer;
        }

        return $quoteTransfer->setView($this->resolveView($quoteTransfer));
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    protected function resolveView(QuoteTransfer $quoteTransfer): string
    {
        $customer = $quoteTransfer->getCustomer();

        $defaultCartView = null;
        if ($customer !== null && $customer->getWebUiSettings() !== null) {
            $defaultCartView = $customer->getWebUiSettings()->getDefaultCartView();
        }

        if ($defaultCartView !== null) {
            return $defaultCartView;
        }

        return $this->config->getFallbackView();
    }
}
