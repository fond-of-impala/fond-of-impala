<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserMapper implements CompanyUserMapperInterface
{
    /**
     * @param array<int, array<string, int>> $nonManufacturerData
     *
     * @return array<\Generated\Shared\Transfer\CompanyUserTransfer>
     */
    public function fromNonManufacturerData(array $nonManufacturerData): array
    {
        $companyUserTransfers = [];

        foreach ($nonManufacturerData as $nonManufacturerDataItem) {
            $companyUserTransfers[] = $this->fromNonManufacturerDataItem($nonManufacturerDataItem);
        }

        return $companyUserTransfers;
    }

    /**
     * @param array<string, int> $nonManufacturerDataItem
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function fromNonManufacturerDataItem(array $nonManufacturerDataItem): CompanyUserTransfer
    {
        $companyRoleTransfer = (new CompanyRoleTransfer())
            ->setIdCompanyRole($nonManufacturerDataItem['id_company_role']);

        $companyRoleCollectionTransfer = (new CompanyRoleCollectionTransfer())
            ->addRole($companyRoleTransfer);

        return (new CompanyUserTransfer())
            ->setFkCompany($nonManufacturerDataItem['id_company'])
            ->setFkCompanyBusinessUnit($nonManufacturerDataItem['id_company_business_unit'])
            ->setIsActive(true)
            ->setCompanyRoleCollection($companyRoleCollectionTransfer);
    }
}
