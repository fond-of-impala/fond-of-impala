<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;

interface BulkProcessorInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
     */
    public function process(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkResponseTransfer;
}
