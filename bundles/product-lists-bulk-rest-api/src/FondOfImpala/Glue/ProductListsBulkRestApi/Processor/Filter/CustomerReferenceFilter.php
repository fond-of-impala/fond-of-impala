<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;

class CustomerReferenceFilter implements CustomerReferenceFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest $restRequest
     *
     * @return string|null
     */
    public function filterFromRestRequest(RestRequest $restRequest): ?string
    {
        $getUserMethod = 'getUser';

        if (method_exists($restRequest, 'getRestUser')) { // @phpstan-ignore-line
            $getUserMethod = 'getRestUser';
        }

        if ($restRequest->$getUserMethod() === null) {
            return null;
        }

        /** @var \Generated\Shared\Transfer\RestUserTransfer|\Spryker\Glue\GlueApplication\Rest\Request\Data\UserInterface $restUser */
        $restUser = $restRequest->$getUserMethod();

        return $restUser->getNaturalIdentifier();
    }
}
