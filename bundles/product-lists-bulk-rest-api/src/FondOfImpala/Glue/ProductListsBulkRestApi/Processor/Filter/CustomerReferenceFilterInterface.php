<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface CustomerReferenceFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string|null
     */
    public function filterFromRestRequest(RestRequestInterface $restRequest): ?string;
}
