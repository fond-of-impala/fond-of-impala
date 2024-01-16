<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsTotalsTransfer;

class RestCartsTotalsMapper implements RestCartsTotalsMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartsTotalsTransfer
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): RestCartsTotalsTransfer
    {
        $totalsTransfer = $quoteTransfer->getTotals();

        if ($totalsTransfer === null) {
            return new RestCartsTotalsTransfer();
        }

        $restCartsTotalsTransfer = (new RestCartsTotalsTransfer())
            ->fromArray($totalsTransfer->toArray(), true);

        $taxTotalTransfer = $totalsTransfer->getTaxTotal();

        if ($taxTotalTransfer !== null) {
            $restCartsTotalsTransfer->setTaxTotal($taxTotalTransfer->getAmount());
        }

        return $restCartsTotalsTransfer;
    }
}
