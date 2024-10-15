<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class PermissionChecker implements PermissionCheckerInterface
{
    /**
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationPermissionPluginInterface>
     */
    protected array $erpOrderCancellationPermissionPlugins;

    /**
     * @param array $erpOrderCancellationPermissionPlugins
     */
    public function __construct(array $erpOrderCancellationPermissionPlugins)
    {
        $this->erpOrderCancellationPermissionPlugins = $erpOrderCancellationPermissionPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param string $type
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function checkPermission(ErpOrderCancellationTransfer $erpOrderCancellationTransfer, CompanyUserTransfer $companyUserTransfer, string $type): bool
    {
        foreach ($this->erpOrderCancellationPermissionPlugins as $erpOrderCancellationPermissionPlugin) {
            if ($erpOrderCancellationPermissionPlugin->isApplicable($erpOrderCancellationTransfer, $companyUserTransfer, $type) === false) {
                continue;
            }

            if ($erpOrderCancellationPermissionPlugin->can($erpOrderCancellationTransfer, $companyUserTransfer) === false) {
                return false;
            }
        }

        return true;
    }
}
