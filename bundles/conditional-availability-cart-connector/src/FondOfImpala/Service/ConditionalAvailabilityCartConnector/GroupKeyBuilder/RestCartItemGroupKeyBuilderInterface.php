<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Generated\Shared\Transfer\RestCartItemTransfer;

interface RestCartItemGroupKeyBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return string
     */
    public function build(RestCartItemTransfer $restCartItemTransfer): string;
}
