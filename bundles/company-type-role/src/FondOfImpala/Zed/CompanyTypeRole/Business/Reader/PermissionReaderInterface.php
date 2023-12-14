<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Reader;

use Generated\Shared\Transfer\PermissionCollectionTransfer;

interface PermissionReaderInterface
{
    /**
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function getPermissions(): PermissionCollectionTransfer;

    /**
     * @return array<\Generated\Shared\Transfer\PermissionSetTransfer>
     */
    public function getPermissionSets(): array;
}
