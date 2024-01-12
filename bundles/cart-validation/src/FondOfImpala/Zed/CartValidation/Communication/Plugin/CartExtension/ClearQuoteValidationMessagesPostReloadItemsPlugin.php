<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CartValidation\Communication\Plugin\CartExtension;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CartExtension\Dependency\Plugin\PostReloadItemsPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CartValidation\Business\CartValidationFacadeInterface getFacade()
 */
class ClearQuoteValidationMessagesPostReloadItemsPlugin extends AbstractPlugin implements PostReloadItemsPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function postReloadItems(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFacade()->clearQuoteValidationMessages($quoteTransfer);
    }
}
