<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence;

interface ConditionalAvailabilityCheckoutConnectorRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return int|null
     */
    public function getIdCustomerByCustomerReference(string $customerReference): ?int;
}
