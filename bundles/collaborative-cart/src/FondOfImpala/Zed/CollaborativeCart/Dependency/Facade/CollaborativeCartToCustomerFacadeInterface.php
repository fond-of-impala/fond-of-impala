<?php

namespace FondOfImpala\Zed\CollaborativeCart\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;

interface CollaborativeCartToCustomerFacadeInterface
{
    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function findByReference(string $customerReference): ?CustomerTransfer;
}
