<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\ItemTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

interface CartItemRestResponseBuilderInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $cartResource
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param string $localeName
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function createCartItemResource(
        RestResourceInterface $cartResource,
        ItemTransfer $itemTransfer,
        string $localeName
    ): RestResourceInterface;
}
