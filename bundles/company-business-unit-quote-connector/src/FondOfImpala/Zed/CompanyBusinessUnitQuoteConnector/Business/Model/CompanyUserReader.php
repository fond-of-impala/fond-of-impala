<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model;

use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Communication\Plugin\PermissionExtension\SeeAllCompanyBusinessUnitQuotesPermissionPlugin;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\CompanyBusinessUnitQuoteConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\CompanyBusinessUnitQuoteConnectorRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\CompanyBusinessUnitQuoteConnectorRepositoryInterface $repository
     * @param \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        CompanyBusinessUnitQuoteConnectorRepositoryInterface $repository,
        CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface $permissionFacade
    ) {
        $this->repository = $repository;
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer
     */
    public function getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest(
        CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
    ): CompanyUserReferenceCollectionTransfer {
        $companyUserReferenceCollectionTransfer = new CompanyUserReferenceCollectionTransfer();

        $companyUserTransfer = $this->getActiveByCompanyBusinessUnitQuoteListRequest(
            $companyBusinessUnitQuoteListRequestTransfer,
        );

        if ($companyUserTransfer === null) {
            return $companyUserReferenceCollectionTransfer;
        }

        $canSeeAllCompanyBusinessUnitCarts = $this->permissionFacade->can(
            SeeAllCompanyBusinessUnitQuotesPermissionPlugin::KEY,
            $companyUserTransfer->getIdCompanyUser(),
        );

        if (!$canSeeAllCompanyBusinessUnitCarts) {
            return $companyUserReferenceCollectionTransfer->addCompanyUserReference(
                $companyUserTransfer->getCompanyUserReference(),
            );
        }

        $companyUserReferences = $this->repository->getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest(
            $companyBusinessUnitQuoteListRequestTransfer,
        );

        return $companyUserReferenceCollectionTransfer->setCompanyUserReferences($companyUserReferences);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    protected function getActiveByCompanyBusinessUnitQuoteListRequest(
        CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequestTransfer
    ): ?CompanyUserTransfer {
        if (
            $companyBusinessUnitQuoteListRequestTransfer->getIdCustomer() === null
            || $companyBusinessUnitQuoteListRequestTransfer->getIdCompanyBusinessUnit() === null
        ) {
            return null;
        }

        return $this->repository->getActiveCompanyUserByCompanyBusinessUnitQuoteListRequest(
            $companyBusinessUnitQuoteListRequestTransfer,
        );
    }
}
