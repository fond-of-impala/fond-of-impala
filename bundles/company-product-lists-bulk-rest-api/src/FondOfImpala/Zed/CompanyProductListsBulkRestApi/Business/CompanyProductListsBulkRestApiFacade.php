<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business;

use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\CompanyProductListsBulkRestApiBusinessFactory getFactory()
 */
class CompanyProductListsBulkRestApiFacade extends AbstractFacade implements CompanyProductListsBulkRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return void
     */
    public function persistCompanyProductListRelation(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): void {
        $this->getFactory()->createCompanyProductListRelationPersister()
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
