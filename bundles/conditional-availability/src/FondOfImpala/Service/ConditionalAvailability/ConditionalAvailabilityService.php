<?php

namespace FondOfImpala\Service\ConditionalAvailability;

use DateTime;
use DateTimeInterface;
use Spryker\Service\Kernel\AbstractService;

/**
 * @method \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceFactory getFactory()
 */
class ConditionalAvailabilityService extends AbstractService implements ConditionalAvailabilityServiceInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \DateTimeInterface
     */
    public function generateEarliestDeliveryDate(): DateTimeInterface
    {
        return $this->getFactory()->createEarliestDeliveryDateGenerator()->generate();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \DateTime $dateTime
     *
     * @return \DateTimeInterface
     */
    public function generateEarliestDeliveryDateByDateTime(DateTime $dateTime): DateTimeInterface
    {
        return $this->getFactory()->createEarliestDeliveryDateGenerator()->generateByDateTime($dateTime);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \DateTime $deliveryDate
     *
     * @return \DateTimeInterface
     */
    public function generateLatestOrderDateByDeliveryDate(DateTime $deliveryDate): DateTimeInterface
    {
        return $this->getFactory()->createLatestOrderDateGenerator()->generateByDeliveryDate($deliveryDate);
    }
}
