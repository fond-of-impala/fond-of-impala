<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CartValidation\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CartValidation\Business\CartValidationBusinessFactory getFactory()
 */
class CartValidationFacade extends AbstractFacade implements CartValidationFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function clearQuoteItemValidationMessages(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()
            ->createQuoteItemValidationMessageClearer()
            ->clear($quoteTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function clearQuoteValidationMessages(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()
        ->createQuoteValidationMessageClearer()
        ->clear($quoteTransfer);
    }
}
