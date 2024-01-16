<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class IdCartFilter implements IdCartFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string|null
     */
    public function filterFromRestRequest(RestRequestInterface $restRequest): ?string
    {
        return $restRequest->getResource()
            ->getId();
    }
}
