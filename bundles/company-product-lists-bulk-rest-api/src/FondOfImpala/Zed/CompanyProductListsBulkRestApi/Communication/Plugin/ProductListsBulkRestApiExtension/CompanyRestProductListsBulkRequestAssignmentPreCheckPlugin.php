<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentPreCheckPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CompanyRestProductListsBulkRequestAssignmentPreCheckPlugin extends AbstractPlugin implements RestProductListsBulkRequestAssignmentPreCheckPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return bool
     */
    public function check(RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer): bool
    {
        if ($restProductListsBulkRequestAssignmentTransfer->getCompany() === null) {
            return false;
        }

        return $restProductListsBulkRequestAssignmentTransfer->getCompany()->getId() !== null;
    }

    /**
     * @return bool
     */
    public function terminateOnFailure(): bool
    {
        return false;
    }
}
