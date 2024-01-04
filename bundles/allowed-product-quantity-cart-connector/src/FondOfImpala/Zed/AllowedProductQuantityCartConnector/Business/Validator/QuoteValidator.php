<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator;

use Generated\Shared\Transfer\QuoteTransfer;

class QuoteValidator implements QuoteValidatorInterface
{
    protected ItemsValidatorInterface $itemsValidator;

    /**
     * @param \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemsValidatorInterface $itemsValidator
     */
    public function __construct(ItemsValidatorInterface $itemsValidator)
    {
        $this->itemsValidator = $itemsValidator;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function validateAndAppendResult(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $itemTransfers = $quoteTransfer->getItems();

        $itemTransfer = $this->itemsValidator->validateAndAppendResult($itemTransfers);

        return $quoteTransfer->setItems($itemTransfer);
    }
}
