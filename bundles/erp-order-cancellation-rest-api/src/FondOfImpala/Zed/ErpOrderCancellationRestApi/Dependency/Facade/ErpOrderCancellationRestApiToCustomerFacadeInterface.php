<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;

interface ErpOrderCancellationRestApiToCustomerFacadeInterface
{
    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function findByReference(string $reference): ?CustomerTransfer;
}
