<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Processor\Validation;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface RestApiErrorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addPriceListNotFoundError(RestResponseInterface $restResponse): RestResponseInterface;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addPriceListIdMissingError(RestResponseInterface $restResponse): RestResponseInterface;
}
