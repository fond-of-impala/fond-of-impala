<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Orm\Zed\CompanyRole\Persistence\Base\SpyCompanyRole;

/**
 * @codeCoverageIgnore
 */
class CompanyRoleMapper implements CompanyRoleMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\Base\SpyCompanyRole $spyCompanyRole
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    public function fromSpyCompanyRole(SpyCompanyRole $spyCompanyRole): CompanyRoleTransfer
    {
        return (new CompanyRoleTransfer())->fromArray($spyCompanyRole->toArray(), true);
    }
}
