<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

class GroupKeyBuilder implements GroupKeyBuilderInterface
{
    /**
     * @var string
     */
    public const GROUP_KEY_DELIMITER = '.';

    /**
     * @param string $sku
     * @param string $deliveryDate
     *
     * @return string
     */
    public function build(string $sku, string $deliveryDate): string
    {
        return sprintf('%s%s%s', $sku, static::GROUP_KEY_DELIMITER, $deliveryDate);
    }
}
