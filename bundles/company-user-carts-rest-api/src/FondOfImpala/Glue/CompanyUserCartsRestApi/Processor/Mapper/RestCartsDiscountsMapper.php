<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsDiscountsTransfer;

class RestCartsDiscountsMapper implements RestCartsDiscountsMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<\Generated\Shared\Transfer\RestCartsDiscountsTransfer>
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): array
    {
        $restCartsDiscountsTransfers = [];

        foreach ($quoteTransfer->getVoucherDiscounts() as $discountTransfer) {
            $restCartsDiscountsTransfers[] = (new RestCartsDiscountsTransfer())
                ->fromArray($discountTransfer->toArray(), true);
        }

        foreach ($quoteTransfer->getCartRuleDiscounts() as $discountTransfer) {
            $restCartsDiscountsTransfers[] = (new RestCartsDiscountsTransfer())
                ->fromArray($discountTransfer->toArray(), true);
        }

        return $restCartsDiscountsTransfers;
    }
}
