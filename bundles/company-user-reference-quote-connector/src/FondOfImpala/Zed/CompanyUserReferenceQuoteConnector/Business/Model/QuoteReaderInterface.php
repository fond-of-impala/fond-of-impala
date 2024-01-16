<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model;

use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;

interface QuoteReaderInterface
{
    /**
     * @param array<string> $companyUserReferences
     *
     * @return array<int>
     */
    public function findQuoteIdsByCompanyUserReferences(array $companyUserReferences): array;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer $companyUserReferenceCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findQuotesByCompanyUserReferences(
        CompanyUserReferenceCollectionTransfer $companyUserReferenceCollectionTransfer
    ): QuoteCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findByCompanyUser(CompanyUserTransfer $companyUserTransfer): QuoteCollectionTransfer;

    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findByCompanyUserReference(string $companyUserReference): QuoteCollectionTransfer;
}
