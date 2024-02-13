<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ProductListsBulkRestApi\Business\ProductListsBulkRestApiBusinessFactory getFactory()
 */
class ProductListsBulkRestApiFacade extends AbstractFacade implements ProductListsBulkRestApiFacadeInterface
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

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
     */
    public function bulkProcess(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkResponseTransfer {
        return $this->getFactory()->createBulkProcessor()
            ->process($restProductListsBulkRequestTransfer);
    }
}
