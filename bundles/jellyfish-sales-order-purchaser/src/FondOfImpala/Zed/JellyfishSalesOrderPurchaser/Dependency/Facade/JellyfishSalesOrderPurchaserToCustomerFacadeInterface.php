<?php

namespace FondOfImpala\Zed\JellyfishSalesOrderPurchaser\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;

interface JellyfishSalesOrderPurchaserToCustomerFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomer(CustomerTransfer $customerTransfer): CustomerTransfer;
}
