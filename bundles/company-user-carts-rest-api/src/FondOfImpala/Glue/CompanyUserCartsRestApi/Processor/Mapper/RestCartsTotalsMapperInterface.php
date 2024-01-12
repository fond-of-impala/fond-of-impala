<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsTotalsTransfer;

interface RestCartsTotalsMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartsTotalsTransfer
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): RestCartsTotalsTransfer;
}
