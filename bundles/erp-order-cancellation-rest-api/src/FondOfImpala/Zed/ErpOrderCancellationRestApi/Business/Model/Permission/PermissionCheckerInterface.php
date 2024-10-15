<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;

interface PermissionCheckerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param string $type
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function checkPermission(ErpOrderCancellationTransfer $erpOrderCancellationTransfer, CompanyUserTransfer $companyUserTransfer, string $type): bool;
}
