<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;

interface ItemsCategorizerInterface
{
    /**
     * @var string
     */
    public const CATEGORY_ADDABLE = 'addable';

    /**
     * @var string
     */
    public const CATEGORY_REMOVABLE = 'removable';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
     *
     * @return array<string, array<\Generated\Shared\Transfer\ItemTransfer>>
     */
    public function categorize(
        QuoteTransfer $quoteTransfer,
        RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
    ): array;
}
