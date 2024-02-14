<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

interface CompanyTypeProductListsBulkRestApiFacadeInterface
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
