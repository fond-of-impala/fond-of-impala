<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander;

use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface RestClaimCartRequestExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestClaimCartRequestTransfer
     */
    public function expand(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer,
        RestRequestInterface $restRequest
    ): RestClaimCartRequestTransfer;
}
