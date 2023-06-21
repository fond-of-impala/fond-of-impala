<?php

namespace FondOfImpala\Service\ConditionalAvailability;

use FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGenerator;
use FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGeneratorInterface;
use FondOfImpala\Service\ConditionalAvailability\Generator\EarliestOrderDateGenerator;
use FondOfImpala\Service\ConditionalAvailability\Generator\EarliestOrderDateGeneratorInterface;
use FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGenerator;
use FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGeneratorInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;

/**
 * @method \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig getConfig()
 */
class ConditionalAvailabilityServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGeneratorInterface
     */
    public function createEarliestDeliveryDateGenerator(): EarliestDeliveryDateGeneratorInterface
    {
        return new EarliestDeliveryDateGenerator(
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGeneratorInterface
     */
    public function createLatestOrderDateGenerator(): LatestOrderDateGeneratorInterface
    {
        return new LatestOrderDateGenerator(
            $this->createEarliestOrderDateGenerator(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Service\ConditionalAvailability\Generator\EarliestOrderDateGeneratorInterface
     */
    protected function createEarliestOrderDateGenerator(): EarliestOrderDateGeneratorInterface
    {
        return new EarliestOrderDateGenerator();
    }
}
