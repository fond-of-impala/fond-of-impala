<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence;

interface ConditionalAvailabilityCartConnectorRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return int|null
     */
    public function getIdCustomerByCustomerReference(string $customerReference): ?int;
}
