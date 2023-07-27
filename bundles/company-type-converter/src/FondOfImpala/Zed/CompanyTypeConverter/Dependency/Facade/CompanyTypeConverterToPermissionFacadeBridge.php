<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyTypeConverterToPermissionFacadeBridge implements CompanyTypeConverterToPermissionFacadeInterface
{
    /**
     * @var \Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \Spryker\Zed\Permission\Business\PermissionFacadeInterface $permissionFacade
     */
    public function __construct(PermissionFacadeInterface $permissionFacade)
    {
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function findMergedRegisteredNonInfrastructuralPermissions(): PermissionCollectionTransfer
    {
        return $this->permissionFacade->findMergedRegisteredNonInfrastructuralPermissions();
    }

    /**
     * @param string $key
     *
     * @return \Generated\Shared\Transfer\PermissionTransfer|null
     */
    public function findPermissionByKey(string $key): ?PermissionTransfer
    {
        return $this->permissionFacade->findPermissionByKey($key);
    }
}
