<?php

namespace FondOfImpala\Zed\WebUiSettings\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface WebUiSettingsFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(QuoteTransfer $quoteTransfer): QuoteTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function handleWebUiSettings(CustomerTransfer $customerTransfer): CustomerTransfer;
}
