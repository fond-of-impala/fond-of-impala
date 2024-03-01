<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

interface BusinessCentralProductListsBulkRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function expandRestProductListsBulkRequest(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkRequestTransfer;
}
