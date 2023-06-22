<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerReaderInterface
{
    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerByCustomerReference(string $customerReference): CustomerTransfer;
}
