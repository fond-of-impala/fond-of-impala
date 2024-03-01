<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\CompanyTypeProductListsBulkRestApiBusinessFactory getFactory()
 */
class CompanyTypeProductListsBulkRestApiFacade extends AbstractFacade implements CompanyTypeProductListsBulkRestApiFacadeInterface
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
