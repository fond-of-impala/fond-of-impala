<?php

namespace FondOfImpala\Glue\CustomerProductListsBulkRestApi\Plugin\ProductListsBulkRestApiExtension;

use FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCustomerTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

class CustomerRestProductListsBulkRequestAssignmentMapperPlugin extends AbstractPlugin implements RestProductListsBulkRequestAssignmentMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer
     */
    public function mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(
        RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer,
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): RestProductListsBulkRequestAssignmentTransfer {
        $restProductListsBulkAssignmentCustomerTransfer = $restProductListsBulkAssignmentTransfer->getCustomer();

        if ($restProductListsBulkAssignmentCustomerTransfer === null) {
            return $restProductListsBulkRequestAssignmentTransfer;
        }

        $restProductListsBulkRequestAssignmentCustomerTransfer = (new RestProductListsBulkRequestAssignmentCustomerTransfer())
            ->fromArray($restProductListsBulkAssignmentCustomerTransfer->toArray(), true);

        return $restProductListsBulkRequestAssignmentTransfer->setCustomer(
            $restProductListsBulkRequestAssignmentCustomerTransfer,
        );
    }
}
