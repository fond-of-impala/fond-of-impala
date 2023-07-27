<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business;

use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface getRepository()
 */
class CompanyUsersBulkRestApiFacade extends AbstractFacade implements CompanyUsersBulkRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    public function bulkProcess(
        RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
    ): RestCompanyUsersBulkResponseTransfer {
        return $this->getFactory()
            ->createBulkManager()
            ->handleBulkRequest($restCompanyUsersBulkRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer
     *
     * @return void
     */
    public function createCompanyUserBulkMode(RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer): void
    {
        $this->getFactory()
            ->createBulkManager()
            ->createCompanyUser($restCompanyUsersBulkItemCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUserBulkMode(RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer): void
    {
        $this->getFactory()
            ->createBulkManager()
            ->deleteCompanyUser($restCompanyUsersBulkItemCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expandWithCompany(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        return $this->getFactory()->createCompanyExpander()->expand($companyUsersBulkPreparationCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expandWithCustomerByReference(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        return $this->getFactory()->createCustomerByReferenceExpander()->expand($companyUsersBulkPreparationCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expandWithCustomerByMail(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        return $this->getFactory()->createCustomerByMailExpander()->expand($companyUsersBulkPreparationCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expandCompanyTransfersWithCompanyBusinessUnits(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        return $this->getFactory()->createCompanyBusinessUnitToCompanyTransferExpander()->expand($companyUsersBulkPreparationCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expandCompanyTransfersWithCompanyRoles(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        return $this->getFactory()->createCompanyRolesToCompanyTransferExpander()->expand($companyUsersBulkPreparationCollectionTransfer);
    }
}
