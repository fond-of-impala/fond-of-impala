<?php

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;

interface CustomerCompanyUserConnectorRepositoryInterface
{
    /**
     * @param int $fkCustomer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUsersByFkCustomer(int $fkCustomer): CompanyUserCollectionTransfer;
}
