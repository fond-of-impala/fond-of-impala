<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter;

use Generated\Shared\Transfer\QuoteTransfer;

class SkusFilter implements SkusFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string>
     */
    public function filterFromQuote(QuoteTransfer $quoteTransfer): array
    {
        $skus = [];

        foreach ($quoteTransfer->getItems() as $item) {
            $skus[] = $item->getSku();
        }

        return array_unique($skus);
    }
}
