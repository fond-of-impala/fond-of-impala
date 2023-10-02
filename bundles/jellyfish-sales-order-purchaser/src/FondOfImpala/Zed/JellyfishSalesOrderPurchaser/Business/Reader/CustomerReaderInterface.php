<?php

namespace FondOfImpala\Zed\JellyfishSalesOrderPurchaser\Business\Reader;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomer(CustomerTransfer $customerTransfer): CustomerTransfer;
}
