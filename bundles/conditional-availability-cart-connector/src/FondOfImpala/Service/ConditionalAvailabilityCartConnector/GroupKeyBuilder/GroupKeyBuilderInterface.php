<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

interface GroupKeyBuilderInterface
{
    /**
     * @param string $sku
     * @param string $deliveryDate
     *
     * @return string
     */
    public function build(string $sku, string $deliveryDate): string;
}
