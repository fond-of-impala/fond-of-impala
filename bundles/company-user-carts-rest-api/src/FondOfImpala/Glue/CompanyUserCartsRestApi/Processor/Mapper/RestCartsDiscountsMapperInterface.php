<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;

interface RestCartsDiscountsMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<\Generated\Shared\Transfer\RestCartsDiscountsTransfer>
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): array;
}
