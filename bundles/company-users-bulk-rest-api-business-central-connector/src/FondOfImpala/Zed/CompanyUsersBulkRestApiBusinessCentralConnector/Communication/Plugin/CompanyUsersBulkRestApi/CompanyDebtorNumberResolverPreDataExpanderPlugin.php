<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Communication\Plugin\CompanyUsersBulkRestApi;

use FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\CompanyUsersBulkRestApiBusinessCentralConnectorFacadeInterface getFacade()
 */
class CompanyDebtorNumberResolverPreDataExpanderPlugin extends AbstractPlugin implements CompanyUsersBulkDataExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expand(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        return $this->getFacade()->expandWithCompanyDebtorNumber($companyUsersBulkPreparationCollectionTransfer);
    }
}
