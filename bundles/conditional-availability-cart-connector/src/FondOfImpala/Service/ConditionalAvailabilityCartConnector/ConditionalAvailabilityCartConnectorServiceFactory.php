<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector;

use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilder;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilder;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilder;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;

class ConditionalAvailabilityCartConnectorServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface
     */
    public function createItemGroupKeyBuilder(): ItemGroupKeyBuilderInterface
    {
        return new ItemGroupKeyBuilder($this->createGroupKeyBuilder());
    }

    /**
     * @return \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface
     */
    public function createRestCartItemGroupKeyBuilder(): RestCartItemGroupKeyBuilderInterface
    {
        return new RestCartItemGroupKeyBuilder($this->createGroupKeyBuilder());
    }

    /**
     * @return \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface
     */
    protected function createGroupKeyBuilder(): GroupKeyBuilderInterface
    {
        return new GroupKeyBuilder();
    }
}
