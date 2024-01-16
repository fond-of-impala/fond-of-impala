<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\CompanyUserQuote\Zed;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CompanyUserQuoteStub implements CompanyUserQuoteStubInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function getCompanyUserQuoteCollectionByCriteria(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer
    {
        /** @var \Generated\Shared\Transfer\QuoteCollectionTransfer $quoteCollectionTransfer */
        $quoteCollectionTransfer = $this->zedRequestClient->call(
            '/company-user-quote/gateway/get-company-user-quote-collection-by-criteria',
            $quoteCriteriaFilterTransfer,
        );

        return $quoteCollectionTransfer;
    }
}
