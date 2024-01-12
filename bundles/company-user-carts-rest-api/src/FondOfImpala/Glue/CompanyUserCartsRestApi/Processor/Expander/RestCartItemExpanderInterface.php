<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander;

use Generated\Shared\Transfer\RestCartItemTransfer;

interface RestCartItemExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartItemTransfer
     */
    public function expand(RestCartItemTransfer $restCartItemTransfer): RestCartItemTransfer;
}
