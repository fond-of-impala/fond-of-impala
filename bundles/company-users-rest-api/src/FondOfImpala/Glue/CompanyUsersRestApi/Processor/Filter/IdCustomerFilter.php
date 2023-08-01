<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class IdCustomerFilter implements IdCustomerFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return int|null
     */
    public function filterFromRestRequest(RestRequestInterface $restRequest): ?int
    {
        $getUserMethod = 'getUser';

        if (method_exists($restRequest, 'getRestUser')) {// @phpstan-ignore-line
            $getUserMethod = 'getRestUser';
        }

        if ($restRequest->$getUserMethod() === null) {
            return null;
        }

        /** @var \Generated\Shared\Transfer\RestUserTransfer|\Spryker\Glue\GlueApplication\Rest\Request\Data\UserInterface $restUser */
        $restUser = $restRequest->$getUserMethod();

        return $restUser->getSurrogateIdentifier();
    }
}
