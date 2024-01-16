<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter;

use Generated\Shared\Transfer\RestCustomerTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface RestCustomerFilterInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestCustomerTransfer
     */
    public function fromRestRequest(RestRequestInterface $restRequest): RestCustomerTransfer;
}
