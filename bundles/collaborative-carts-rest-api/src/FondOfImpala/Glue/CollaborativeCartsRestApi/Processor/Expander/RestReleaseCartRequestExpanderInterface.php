<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander;

use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface RestReleaseCartRequestExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartRequestTransfer
     */
    public function expand(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer,
        RestRequestInterface $restRequest
    ): RestReleaseCartRequestTransfer;
}
