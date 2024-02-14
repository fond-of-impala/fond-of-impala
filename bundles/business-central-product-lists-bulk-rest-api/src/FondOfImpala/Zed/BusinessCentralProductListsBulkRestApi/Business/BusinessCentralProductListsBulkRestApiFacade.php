<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\BusinessCentralProductListsBulkRestApiBusinessFactory getFactory()
 */
class BusinessCentralProductListsBulkRestApiFacade extends AbstractFacade implements BusinessCentralProductListsBulkRestApiFacadeInterface
{
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
