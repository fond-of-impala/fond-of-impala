<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @codeCoverageIgnore
 */
class CompanyUserCartsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @return array<string>
     */
    public function getAllowedFieldsToPatchInQuote(): array
    {
        return [
            QuoteTransfer::NAME,
            QuoteTransfer::COMMENT,
            QuoteTransfer::FILTERS,
            QuoteTransfer::REFERENCE,
        ];
    }
}
