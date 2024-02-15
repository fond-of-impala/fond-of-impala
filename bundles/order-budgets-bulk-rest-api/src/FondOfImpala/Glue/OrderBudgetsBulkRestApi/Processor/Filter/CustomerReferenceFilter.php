<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Filter;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerReferenceFilter implements CustomerReferenceFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string|null
     */
    public function filterFromRestRequest(RestRequestInterface $restRequest): ?string
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
