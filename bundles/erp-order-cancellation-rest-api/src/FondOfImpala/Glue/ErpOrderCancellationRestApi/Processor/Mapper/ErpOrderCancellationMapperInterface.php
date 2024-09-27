<?php

namespace FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface ErpOrderCancellationMapperInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer|null $attributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer
     */
    public function createRequest(
        RestRequestInterface $restRequest,
        ?RestErpOrderCancellationAttributesTransfer $attributesTransfer = null
    ): RestErpOrderCancellationRequestTransfer;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer
     */
    public function createAttributesFromRequest(RestRequestInterface $restRequest): RestErpOrderCancellationAttributesTransfer;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer
     */
    public function createFilterFromRequest(RestRequestInterface $restRequest): RestErpOrderCancellationFilterTransfer;
}
