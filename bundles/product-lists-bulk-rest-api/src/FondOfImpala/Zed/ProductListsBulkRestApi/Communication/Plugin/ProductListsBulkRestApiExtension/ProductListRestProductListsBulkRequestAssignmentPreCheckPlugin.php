<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentPreCheckPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ProductListRestProductListsBulkRequestAssignmentPreCheckPlugin extends AbstractPlugin implements RestProductListsBulkRequestAssignmentPreCheckPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return bool
     */
    public function check(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): bool {
        $validProductListsCount = 0;

        foreach ($restProductListsBulkRequestAssignmentTransfer->getProductListsToAssign() as $transfer) {
            if ($transfer->getId() === null) {
                continue;
            }

            ++$validProductListsCount;
        }

        foreach ($restProductListsBulkRequestAssignmentTransfer->getProductListsToUnassign() as $transfer) {
            if ($transfer->getId() === null) {
                continue;
            }

            ++$validProductListsCount;
        }

        return $validProductListsCount > 0;
    }

    /**
     * @return bool
     */
    public function terminateOnFailure(): bool
    {
        return true;
    }
}
