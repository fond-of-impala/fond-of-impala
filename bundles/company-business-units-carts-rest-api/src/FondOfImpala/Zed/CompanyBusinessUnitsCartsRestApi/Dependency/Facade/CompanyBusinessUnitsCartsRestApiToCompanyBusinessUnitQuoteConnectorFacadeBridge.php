<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade;

use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\CompanyBusinessUnitQuoteConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;

class CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridge implements
    CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\CompanyBusinessUnitQuoteConnectorFacadeInterface
     */
    protected $companyBusinessUnitQuoteConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\CompanyBusinessUnitQuoteConnectorFacadeInterface $companyBusinessUnitQuoteConnectorFacade
     */
    public function __construct(
        CompanyBusinessUnitQuoteConnectorFacadeInterface $companyBusinessUnitQuoteConnectorFacade
    ) {
        $this->companyBusinessUnitQuoteConnectorFacade = $companyBusinessUnitQuoteConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    public function findQuotes(
        CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
    ): CompanyBusinessUnitQuoteListTransfer {
        return $this->companyBusinessUnitQuoteConnectorFacade->findQuotes($companyBusinessUnitQuoteListRequestTransfer);
    }
}
