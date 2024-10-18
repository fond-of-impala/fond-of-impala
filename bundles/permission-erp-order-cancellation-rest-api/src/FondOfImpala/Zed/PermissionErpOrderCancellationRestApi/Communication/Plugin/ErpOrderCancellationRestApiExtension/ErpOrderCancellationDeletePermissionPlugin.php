<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellationRestApiExtension;

use FondOfImpala\Shared\ErpOrderCancellationRestApiExtension\ErpOrderCancellationRestApiExtensionConstants;
use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationPermissionPluginInterface;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\PermissionExtension\ErpOrderCancellationManagePermissionPlugin;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence\PermissionErpOrderCancellationRestApiRepositoryInterface getRepository()
 */
class ErpOrderCancellationDeletePermissionPlugin extends AbstractPlugin implements ErpOrderCancellationPermissionPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param string|null $type
     *
     * @return bool
     */
    public function isApplicable(
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer,
        CompanyUserTransfer $companyUserTransfer,
        ?string $type = null
    ): bool {
        return $type === ErpOrderCancellationRestApiExtensionConstants::PERMISSION_TYPE_DELETE;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    public function can(ErpOrderCancellationTransfer $erpOrderCancellationTransfer, CompanyUserTransfer $companyUserTransfer): bool
    {
        return $this->getRepository()->hasPermission($companyUserTransfer->getIdCompanyUser(), ErpOrderCancellationManagePermissionPlugin::KEY);
    }
}
