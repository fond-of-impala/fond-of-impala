<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model;

use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;

class QuoteReader implements QuoteReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface
     */
    protected $quoteFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepositoryInterface $repository
     * @param \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface $quoteFacade
     */
    public function __construct(
        CompanyUserReferenceQuoteConnectorRepositoryInterface $repository,
        CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface $quoteFacade
    ) {
        $this->repository = $repository;
        $this->quoteFacade = $quoteFacade;
    }

    /**
     * @param array<string> $companyUserReferences
     *
     * @return array<int>
     */
    public function findQuoteIdsByCompanyUserReferences(array $companyUserReferences): array
    {
        return $this->repository->findQuoteIdsByCompanyUserReferences($companyUserReferences);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer $companyUserReferenceCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findQuotesByCompanyUserReferences(
        CompanyUserReferenceCollectionTransfer $companyUserReferenceCollectionTransfer
    ): QuoteCollectionTransfer {
        $companyUserReferences = $companyUserReferenceCollectionTransfer->getCompanyUserReferences();

        $quoteIds = $this->findQuoteIdsByCompanyUserReferences($companyUserReferences);

        return $this->findByQuoteIds($quoteIds);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findByCompanyUser(CompanyUserTransfer $companyUserTransfer): QuoteCollectionTransfer
    {
        $companyUserReference = $companyUserTransfer->getCompanyUserReference();

        if ($companyUserReference === null) {
            return new QuoteCollectionTransfer();
        }

        return $this->findByCompanyUserReference($companyUserReference);
    }

    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findByCompanyUserReference(string $companyUserReference): QuoteCollectionTransfer
    {
        $quoteIds = $this->repository->findQuoteIdsByCompanyUserReference($companyUserReference);

        return $this->findByQuoteIds($quoteIds);
    }

    /**
     * @param array $quoteIds
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected function findByQuoteIds(array $quoteIds): QuoteCollectionTransfer
    {
        if (count($quoteIds) === 0) {
            return new QuoteCollectionTransfer();
        }

        $quoteCriteriaFilterTransfer = (new QuoteCriteriaFilterTransfer())
            ->setQuoteIds($quoteIds);

        return $this->quoteFacade->getQuoteCollection($quoteCriteriaFilterTransfer);
    }
}
