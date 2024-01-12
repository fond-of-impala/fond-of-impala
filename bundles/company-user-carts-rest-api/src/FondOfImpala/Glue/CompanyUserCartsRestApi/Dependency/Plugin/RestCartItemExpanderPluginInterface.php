<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Dependency\Plugin;

use Generated\Shared\Transfer\RestCartItemTransfer;

interface RestCartItemExpanderPluginInterface
{
    /**
     * Specification:
     * - Expand rest cart item transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartItemTransfer
     */
    public function expand(RestCartItemTransfer $restCartItemTransfer): RestCartItemTransfer;
}
