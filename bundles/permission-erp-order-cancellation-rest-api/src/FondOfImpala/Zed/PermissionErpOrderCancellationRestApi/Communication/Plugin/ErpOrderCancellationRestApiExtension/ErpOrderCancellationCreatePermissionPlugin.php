<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellationRestApiExtension;

use FondOfImpala\Shared\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConstants;
use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationPermissionPluginInterface;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\PermissionExtension\ErpOrderCancellationCreatePermissionPlugin as PermissionErpOrderCancellationCreatePermissionPlugin;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\PermissionExtension\ErpOrderCancellationManagePermissionPlugin;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence\PermissionErpOrderCancellationRestApiRepositoryInterface getRepository()
 */
class ErpOrderCancellationCreatePermissionPlugin extends AbstractPlugin implements ErpOrderCancellationPermissionPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param string|null $type
     * @return bool
     */
    public function isApplicable(ErpOrderCancellationTransfer $erpOrderCancellationTransfer, CompanyUserTransfer $companyUserTransfer, ?string $type = null): bool
    {
        return $type === ErpOrderCancellationRestApiConstants::PERMISSION_TYPE_CREATE;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function can(ErpOrderCancellationTransfer $erpOrderCancellationTransfer, CompanyUserTransfer $companyUserTransfer): bool
    {
        return $this->getRepository()->hasPermission($companyUserTransfer->getIdCompanyUser(), PermissionErpOrderCancellationCreatePermissionPlugin::KEY) !== null
            || $this->getRepository()->hasPermission($companyUserTransfer->getIdCompanyUser(), ErpOrderCancellationManagePermissionPlugin::KEY) !== null;
    }

}
