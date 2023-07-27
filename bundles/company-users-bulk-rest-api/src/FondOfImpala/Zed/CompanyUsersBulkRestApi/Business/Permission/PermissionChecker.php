<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\PermissionExtension\CanBulkCreateCompanyUsersPermissionPlugin;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;

class PermissionChecker implements PermissionCheckerInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface
     */
    protected CompanyUsersBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface $repository
     */
    public function __construct(CompanyUsersBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return bool
     */
    public function check(
        RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
    ): bool {
        return $this->repository->hasPermission(
            CanBulkCreateCompanyUsersPermissionPlugin::KEY,
            $restCompanyUsersBulkRequestTransfer->getOriginatorReference(),
        );
    }
}
