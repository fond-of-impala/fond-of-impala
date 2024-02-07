<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\ProductListsBulk;

use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface ProductListsBulkProcessorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function process(
        RestRequestInterface $restRequest,
        RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
    ): RestResponseInterface;
}
