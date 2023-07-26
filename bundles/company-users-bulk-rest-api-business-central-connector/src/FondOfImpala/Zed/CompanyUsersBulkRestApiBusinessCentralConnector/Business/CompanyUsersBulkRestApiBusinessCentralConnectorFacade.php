<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business;

use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\CompanyUsersBulkRestApiBusinessCentralConnectorBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Persistence\CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface getRepository()
 */
class CompanyUsersBulkRestApiBusinessCentralConnectorFacade extends AbstractFacade implements CompanyUsersBulkRestApiBusinessCentralConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expandWithCompanyDebtorNumber(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        return $this->getFactory()->createCompanyDebtorNumberExpander()->expand($companyUsersBulkPreparationCollectionTransfer);
    }
}
