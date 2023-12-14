<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRole;
use Propel\Runtime\Collection\ObjectCollection;

interface CompanyRoleMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\SpyCompanyRole $spyCompanyRole
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    public function mapEntityToTransfer(
        SpyCompanyRole $spyCompanyRole,
        CompanyRoleTransfer $companyRoleTransfer
    ): CompanyRoleTransfer;

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $collection
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function mapObjectCollectionToCompanyRoleCollectionTransfer(
        ObjectCollection $collection
    ): CompanyRoleCollectionTransfer;
}
