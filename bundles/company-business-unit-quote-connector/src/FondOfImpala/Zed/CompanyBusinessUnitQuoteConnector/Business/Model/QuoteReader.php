<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model;

use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;

class QuoteReader implements QuoteReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\CompanyUserReaderInterface
     */
    protected $companyUserReader;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface
     */
    protected $companyUserReferenceQuoteConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface $companyUserReferenceQuoteConnectorFacade
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface $companyUserReferenceQuoteConnectorFacade
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->companyUserReferenceQuoteConnectorFacade = $companyUserReferenceQuoteConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function findByCompanyBusinessUnitQuoteListRequest(
        CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
    ): CompanyBusinessUnitQuoteListTransfer {
        $companyUserReferenceCollectionTransfer = $this->companyUserReader
            ->getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest(
                $companyBusinessUnitQuoteListRequestTransfer,
            );

        $quoteCollectionTransfer = $this->companyUserReferenceQuoteConnectorFacade->findQuotesByCompanyUserReferences(
            $companyUserReferenceCollectionTransfer,
        );

        return (new CompanyBusinessUnitQuoteListTransfer())->setQuotes(
            $quoteCollectionTransfer->getQuotes(),
        );
    }
}
