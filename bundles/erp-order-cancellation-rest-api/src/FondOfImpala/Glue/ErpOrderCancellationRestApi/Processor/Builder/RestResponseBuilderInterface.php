<?php

namespace FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Builder;

use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface RestResponseBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer $restErpOrderCancellationResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildErpOrderCancellationRestResponse(
        RestErpOrderCancellationResponseTransfer $restErpOrderCancellationResponseTransfer
    ): RestResponseInterface;

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer $restErpOrderCancellationCollectionResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildErpOrderCancellationCollectionRestResponse(
        RestErpOrderCancellationCollectionResponseTransfer $restErpOrderCancellationCollectionResponseTransfer
    ): RestResponseInterface;

    /**
     * @param \Generated\Shared\Transfer\RestErrorMessageTransfer|null $restErrorMessageTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildErrorResponse(?RestErrorMessageTransfer $restErrorMessageTransfer = null): RestResponseInterface;
}
