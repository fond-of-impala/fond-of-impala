<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\SpyCompanyUserEntityTransfer;

class CompanyUserMapper implements CompanyUserMapperInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\SpyCompanyUserEntityTransfer> $collection
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function mapCompanyUserCollection(array $collection): CompanyUserCollectionTransfer
    {
        $companyUserCollectionTransfer = new CompanyUserCollectionTransfer();

        foreach ($collection as $companyUserEntityTransfer) {
            $companyUserCollectionTransfer->addCompanyUser($this->mapEntityTransferToCompanyUserTransfer($companyUserEntityTransfer));
        }

        return $companyUserCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyCompanyUserEntityTransfer $companyUserEntityTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapEntityTransferToCompanyUserTransfer(
        SpyCompanyUserEntityTransfer $companyUserEntityTransfer
    ): CompanyUserTransfer {
        $companyUserTransfer = (new CompanyUserTransfer())->fromArray($companyUserEntityTransfer->modifiedToArray(), true);

        if ($companyUserEntityTransfer->getCustomer()) {
            $customerTransfer = (new CustomerTransfer())->fromArray(
                $companyUserEntityTransfer->getCustomer()->modifiedToArray(),
                true,
            );
            $companyUserTransfer->setCustomer($customerTransfer);
        }

        if ($companyUserEntityTransfer->getCompany()) {
            $companyTransfer = (new CompanyTransfer())->fromArray(
                $companyUserEntityTransfer->getCompany()->modifiedToArray(),
                true,
            );
            $companyUserTransfer->setCompany($companyTransfer);
        }

        return $companyUserTransfer;
    }
}
