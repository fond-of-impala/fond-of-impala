<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Expander;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

interface RestProductListsBulkRequestExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function expand(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkRequestTransfer;
}
