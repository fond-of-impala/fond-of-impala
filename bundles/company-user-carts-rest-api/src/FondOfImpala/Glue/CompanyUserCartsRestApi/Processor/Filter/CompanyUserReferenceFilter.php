<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter;

use FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserReferenceFilter implements CompanyUserReferenceFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string|null
     */
    public function filterFromRestRequest(RestRequestInterface $restRequest): ?string
    {
        $parentResource = $restRequest->findParentResourceByType(CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USERS);

        if ($parentResource === null) {
            return null;
        }

        return $parentResource->getId();
    }
}
