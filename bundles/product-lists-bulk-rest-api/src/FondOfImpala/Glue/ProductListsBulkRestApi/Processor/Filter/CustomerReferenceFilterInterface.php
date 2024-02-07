<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;

interface CustomerReferenceFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest $restRequest
     *
     * @return string|null
     */
    public function filterFromRestRequest(RestRequest $restRequest): ?string;
}
