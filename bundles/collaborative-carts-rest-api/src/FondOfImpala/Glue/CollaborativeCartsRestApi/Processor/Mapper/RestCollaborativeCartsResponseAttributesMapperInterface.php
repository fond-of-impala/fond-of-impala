<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCollaborativeCartsResponseAttributesTransfer;

interface RestCollaborativeCartsResponseAttributesMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RestCollaborativeCartsResponseAttributesTransfer
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): RestCollaborativeCartsResponseAttributesTransfer;
}
