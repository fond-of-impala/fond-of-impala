<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander;

use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestClaimCartRequestExpander implements RestClaimCartRequestExpanderInterface
{
    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface
     */
    protected $customerReferenceFilter;

    /**
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface $customerReferenceFilter
     */
    public function __construct(RestCustomerFilterInterface $customerReferenceFilter)
    {
        $this->customerReferenceFilter = $customerReferenceFilter;
    }

    /**
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestClaimCartRequestTransfer
     */
    public function expand(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer,
        RestRequestInterface $restRequest
    ): RestClaimCartRequestTransfer {
        return $this->expandWithCustomer($restClaimCartRequestTransfer, $restRequest);
    }

    /**
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestClaimCartRequestTransfer
     */
    protected function expandWithCustomer(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer,
        RestRequestInterface $restRequest
    ): RestClaimCartRequestTransfer {
        $restCustomerTransfer = $this->customerReferenceFilter->fromRestRequest($restRequest);

        return $restClaimCartRequestTransfer->setNewCustomerReference($restCustomerTransfer->getCustomerReference())
            ->setNewIdCustomer($restCustomerTransfer->getIdCustomer());
    }
}
