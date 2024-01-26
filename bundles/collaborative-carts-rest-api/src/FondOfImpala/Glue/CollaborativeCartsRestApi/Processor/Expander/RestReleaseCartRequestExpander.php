<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander;

use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestReleaseCartRequestExpander implements RestReleaseCartRequestExpanderInterface
{
    protected RestCustomerFilterInterface $customerReferenceFilter;

    /**
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface $customerReferenceFilter
     */
    public function __construct(RestCustomerFilterInterface $customerReferenceFilter)
    {
        $this->customerReferenceFilter = $customerReferenceFilter;
    }

    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartRequestTransfer
     */
    public function expand(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer,
        RestRequestInterface $restRequest
    ): RestReleaseCartRequestTransfer {
        return $this->expandWithCustomer($restReleaseCartRequestTransfer, $restRequest);
    }

    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartRequestTransfer
     */
    protected function expandWithCustomer(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer,
        RestRequestInterface $restRequest
    ): RestReleaseCartRequestTransfer {
        $restCustomerTransfer = $this->customerReferenceFilter->fromRestRequest($restRequest);

        return $restReleaseCartRequestTransfer->setCurrentCustomerReference(
            $restCustomerTransfer->getCustomerReference(),
        );
    }
}
