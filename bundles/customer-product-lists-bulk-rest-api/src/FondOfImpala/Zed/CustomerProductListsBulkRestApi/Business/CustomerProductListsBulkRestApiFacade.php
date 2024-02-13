<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business;

use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\CustomerProductListsBulkRestApiBusinessFactory getFactory()
 */
class CustomerProductListsBulkRestApiFacade extends AbstractFacade implements CustomerProductListsBulkRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return void
     */
    public function persistCustomerProductListRelation(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): void {
        $this->getFactory()->createCustomerProductListRelationPersister()
            ->persist($restProductListsBulkRequestAssignmentTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function expandRestProductListsBulkRequest(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkRequestTransfer {
        return $this->getFactory()->createRestProductListsBulkRequestExpander()
            ->expand($restProductListsBulkRequestTransfer);
    }
}
