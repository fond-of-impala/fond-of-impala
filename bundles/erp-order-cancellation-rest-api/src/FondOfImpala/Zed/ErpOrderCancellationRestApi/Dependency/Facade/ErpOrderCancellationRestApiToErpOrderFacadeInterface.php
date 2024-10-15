<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Generated\Shared\Transfer\ErpOrderTransfer;

interface ErpOrderCancellationRestApiToErpOrderFacadeInterface
{
    /**
     * @param string $reference
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function findErpOrderByReference(string $reference): ?ErpOrderTransfer;

    /**
     * @param string $externalReference
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function findErpOrderByExternalReference(string $externalReference): ?ErpOrderTransfer;
}
