<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUserQuote\Business\Model;

use FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteRepositoryInterface;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Spryker\Zed\Quote\Business\Model\QuoteReader;
use Spryker\Zed\Quote\Dependency\Facade\QuoteToStoreFacadeInterface;

class CompanyUserQuoteReader extends QuoteReader implements CompanyUserQuoteReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteRepositoryInterface
     */
    protected $companyUserQuoteRepository;

    /**
     * @param \FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteRepositoryInterface $companyUserQuoteRepository
     * @param array $quoteExpanderPlugins
     * @param \Spryker\Zed\Quote\Dependency\Facade\QuoteToStoreFacadeInterface $quoteToStoreFacade
     */
    public function __construct(
        CompanyUserQuoteRepositoryInterface $companyUserQuoteRepository,
        array $quoteExpanderPlugins,
        QuoteToStoreFacadeInterface $quoteToStoreFacade
    ) {
        parent::__construct($companyUserQuoteRepository, $quoteExpanderPlugins, $quoteToStoreFacade);
        $this->companyUserQuoteRepository = $companyUserQuoteRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function getFilteredCompanyUserQuoteCollection(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer
    {
        $quoteCollectionTransfer = $this->companyUserQuoteRepository->filterCompanyUserQuoteCollection($quoteCriteriaFilterTransfer);
        $quoteCollectionTransfer = $this->executeExpandQuotePluginsForQuoteCollection($quoteCollectionTransfer);

        return $quoteCollectionTransfer;
    }
}
