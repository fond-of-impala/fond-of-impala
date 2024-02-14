<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

interface RestProductListsBulkRequestAssignmentPreCheckPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return bool
     */
    public function check(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): bool;

    /**
     * @return bool
     */
    public function terminateOnFailure(): bool;
}
