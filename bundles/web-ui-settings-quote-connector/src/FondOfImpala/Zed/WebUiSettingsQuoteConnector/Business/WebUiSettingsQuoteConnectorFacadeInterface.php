<?php

namespace FondOfImpala\Zed\WebUiSettingsQuoteConnector\Business;

use Generated\Shared\Transfer\QuoteTransfer;

interface WebUiSettingsQuoteConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
