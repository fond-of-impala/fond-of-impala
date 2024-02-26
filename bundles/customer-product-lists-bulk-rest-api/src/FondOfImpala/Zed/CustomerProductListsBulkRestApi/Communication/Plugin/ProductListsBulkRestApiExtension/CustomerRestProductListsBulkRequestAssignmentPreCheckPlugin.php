<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentPreCheckPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CustomerRestProductListsBulkRequestAssignmentPreCheckPlugin extends AbstractPlugin implements RestProductListsBulkRequestAssignmentPreCheckPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return bool
     */
    public function check(RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer): bool
    {
        if ($restProductListsBulkRequestAssignmentTransfer->getCustomer() === null) {
            return false;
        }

        return $restProductListsBulkRequestAssignmentTransfer->getCustomer()->getId() !== null;
    }

    /**
     * @return bool
     */
    public function terminateOnFailure(): bool
    {
        return false;
    }
}
