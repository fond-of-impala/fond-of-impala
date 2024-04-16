<?php

namespace FondOfImpala\Zed\WebUiSettings\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\WebUiSettings\Business\WebUiSettingsBusinessFactory getFactory()
 */
class WebUiSettingsFacade extends AbstractFacade implements WebUiSettingsFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()->createQuoteExpander()->expand($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function handleWebUiSettings(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        return $this->getFactory()->createWebUiSettingsManager()->handleCustomerWebUiSettings($customerTransfer);
    }
}
