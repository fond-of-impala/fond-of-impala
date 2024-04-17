<?php

namespace FondOfImpala\Zed\WebUiSettings\Business\Expander;

use FondOfImpala\Zed\WebUiSettings\WebUiSettingsConfig;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    protected WebUiSettingsConfig $config;

    /**
     * @param \FondOfImpala\Zed\WebUiSettings\WebUiSettingsConfig $config
     */
    public function __construct(WebUiSettingsConfig $config)
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
    public function resolveView(QuoteTransfer $quoteTransfer): string
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
