<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter;

use Generated\Shared\Transfer\RestCustomerTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestCustomerFilter implements RestCustomerFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestCustomerTransfer
     */
    public function fromRestRequest(RestRequestInterface $restRequest): RestCustomerTransfer
    {
        $restCustomerTransfer = new RestCustomerTransfer();
        $restUser = $this->getRestUserByRestRequest($restRequest);

        if ($restUser === null) {
            return $restCustomerTransfer;
        }

        return $restCustomerTransfer->setIdCustomer($restUser->getSurrogateIdentifier())
            ->setCustomerReference($restUser->getNaturalIdentifier());
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestUserTransfer|\Spryker\Glue\GlueApplication\Rest\Request\Data\UserInterface|null
     */
    protected function getRestUserByRestRequest(RestRequestInterface $restRequest): ?object
    {
        $getUserMethod = 'getUser';

        if (method_exists($restRequest, 'getRestUser')) {
            $getUserMethod = 'getRestUser';
        }

        return $restRequest->$getUserMethod();
    }
}
