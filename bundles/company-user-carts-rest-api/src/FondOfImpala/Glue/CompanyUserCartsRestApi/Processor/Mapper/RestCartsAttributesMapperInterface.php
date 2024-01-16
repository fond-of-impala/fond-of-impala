<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;

interface RestCartsAttributesMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartsAttributesTransfer
     */
    public function fromQuote(
        QuoteTransfer $quoteTransfer
    ): RestCartsAttributesTransfer;
}
