<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CartValidation\Business;

use FondOfImpala\Zed\CartValidation\Business\Clearer\QuoteItemValidationMessageClearer;
use FondOfImpala\Zed\CartValidation\Business\Clearer\QuoteItemValidationMessageClearerInterface;
use FondOfImpala\Zed\CartValidation\Business\Clearer\QuoteValidationMessageClearer;
use FondOfImpala\Zed\CartValidation\Business\Clearer\QuoteValidationMessageClearerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CartValidationBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CartValidation\Business\Clearer\QuoteValidationMessageClearerInterface
     */
    public function createQuoteValidationMessageClearer(): QuoteValidationMessageClearerInterface
    {
        return new QuoteValidationMessageClearer();
    }

    /**
     * @return \FondOfImpala\Zed\CartValidation\Business\Clearer\QuoteItemValidationMessageClearerInterface
     */
    public function createQuoteItemValidationMessageClearer(): QuoteItemValidationMessageClearerInterface
    {
        return new QuoteItemValidationMessageClearer();
    }
}
