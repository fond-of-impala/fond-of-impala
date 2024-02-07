<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

interface RestProductListsBulkRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function fromRestProductListsBulkRequestAttributes(
        RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
    ): RestProductListsBulkRequestTransfer;
}
