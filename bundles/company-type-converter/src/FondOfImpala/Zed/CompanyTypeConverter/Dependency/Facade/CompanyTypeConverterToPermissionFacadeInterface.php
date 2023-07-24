<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

interface CompanyTypeConverterToPermissionFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function findMergedRegisteredNonInfrastructuralPermissions(): PermissionCollectionTransfer;

    /**
     * @param string $key
     *
     * @return \Generated\Shared\Transfer\PermissionTransfer|null
     */
    public function findPermissionByKey(string $key): ?PermissionTransfer;
}
