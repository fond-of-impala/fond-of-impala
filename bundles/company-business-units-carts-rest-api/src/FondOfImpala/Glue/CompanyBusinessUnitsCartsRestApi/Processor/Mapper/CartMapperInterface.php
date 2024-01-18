<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;

interface CartMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartsAttributesTransfer
     */
    public function mapQuoteTransferToRestCartsAttributesTransfer(
        QuoteTransfer $orderTransfer
    ): RestCartsAttributesTransfer;
}
