<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Persistence;

interface ConditionalAvailabilityCompanyConnectorRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return array<string>
     */
    public function getPossibleAvailabilityChannelsByIdCustomer(int $idCustomer): array;
}
