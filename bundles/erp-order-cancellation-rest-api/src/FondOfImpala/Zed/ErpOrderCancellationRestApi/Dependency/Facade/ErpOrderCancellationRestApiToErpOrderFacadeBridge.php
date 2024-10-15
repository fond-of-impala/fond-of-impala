<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use FondOfOryx\Zed\ErpOrder\Business\ErpOrderFacadeInterface;
use Generated\Shared\Transfer\ErpOrderTransfer;

class ErpOrderCancellationRestApiToErpOrderFacadeBridge implements ErpOrderCancellationRestApiToErpOrderFacadeInterface
{
    /**
     * @var \FondOfOryx\Zed\ErpOrder\Business\ErpOrderFacadeInterface
     */
    protected $facade;

    /**
     * @param \FondOfOryx\Zed\ErpOrder\Business\ErpOrderFacadeInterface $erpOrderCancellationFacade
     */
    public function __construct(ErpOrderFacadeInterface $erpOrderCancellationFacade)
    {
        $this->facade = $erpOrderCancellationFacade;
    }

    /**
     * @param string $reference
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function findErpOrderByReference(string $reference): ?ErpOrderTransfer
    {
        return $this->facade->findErpOrderByReference($reference);
    }

    /**
     * @param string $externalReference
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function findErpOrderByExternalReference(string $externalReference): ?ErpOrderTransfer
    {
        return $this->facade->findErpOrderByExternalReference($externalReference);
    }
}
