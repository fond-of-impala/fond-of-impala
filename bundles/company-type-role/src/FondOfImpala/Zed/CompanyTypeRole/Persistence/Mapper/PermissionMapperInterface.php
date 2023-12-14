<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRole;

interface PermissionMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\SpyCompanyRole $spyCompanyRole
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function fromSpyCompanyRole(SpyCompanyRole $spyCompanyRole): PermissionCollectionTransfer;
}
