<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder;

use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface RestResponseBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildByRestProductListsBulkResponse(
        RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransfer
    ): RestResponseInterface;
}
