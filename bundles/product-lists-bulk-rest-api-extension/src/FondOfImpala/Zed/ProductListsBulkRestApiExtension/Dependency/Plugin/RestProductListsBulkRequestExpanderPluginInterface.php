<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

interface RestProductListsBulkRequestExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function expand(RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer): RestProductListsBulkRequestTransfer;
}
