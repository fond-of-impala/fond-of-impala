<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker;

use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin\PermissionExtension\ReadCompanyUserCartPermissionPlugin;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

class ReadPermissionChecker implements ReadPermissionCheckerInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface
     */
    protected CompanyUserReaderInterface $companyUserReader;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface
     */
    protected CompanyUserCartsRestApiToPermissionFacadeInterface $permissionFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyUserCartsRestApiToPermissionFacadeInterface $permissionFacade
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return bool
     */
    public function checkByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): bool {
        $idCompanyUser = $this->companyUserReader->getIdByRestCompanyUserCartsRequest(
            $restCompanyUserCartsRequestTransfer,
        );

        if ($idCompanyUser === null) {
            return false;
        }

        return $this->checkByIdCompanyUser($idCompanyUser);
    }

    /**
     * @param int $idCompanyUser
     *
     * @return bool
     */
    public function checkByIdCompanyUser(int $idCompanyUser): bool
    {
        return $this->permissionFacade->can(ReadCompanyUserCartPermissionPlugin::KEY, $idCompanyUser);
    }
}
