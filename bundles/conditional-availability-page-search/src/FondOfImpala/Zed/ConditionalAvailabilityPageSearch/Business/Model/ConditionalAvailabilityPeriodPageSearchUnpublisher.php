<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter\IdConditionalAvailabilityFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter\KeyFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityPeriodPageSearchUnpublisher implements ConditionalAvailabilityPeriodPageSearchUnpublisherInterface
{
    protected KeyFilterInterface $keyFilter;

    protected IdConditionalAvailabilityFilterInterface $idConditionalAvailabilityFilter;

    protected ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter\KeyFilterInterface $keyFilter
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter\IdConditionalAvailabilityFilterInterface $idConditionalAvailabilityFilter
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager
     */
    public function __construct(
        KeyFilterInterface $keyFilter,
        IdConditionalAvailabilityFilterInterface $idConditionalAvailabilityFilter,
        ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager
    ) {
        $this->keyFilter = $keyFilter;
        $this->entityManager = $entityManager;
        $this->idConditionalAvailabilityFilter = $idConditionalAvailabilityFilter;
    }

    /**
     * @param string $eventName
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function unpublish(string $eventName, array $eventEntityTransfers): void
    {
        if ($eventName !== ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_UNPUBLISH) {
            $keys = $this->keyFilter->filterFromEventEntities($eventEntityTransfers);

            $this->entityManager->deleteConditionalAvailabilityPeriodSearchPagesByKeys($keys);

            return;
        }

        $conditionalAvailabilityIds = $this->idConditionalAvailabilityFilter->filterFromEventEntities(
            $eventEntityTransfers,
        );

        $this->entityManager->deleteConditionalAvailabilityPeriodSearchPagesByConditionalAvailabilityIds(
            $conditionalAvailabilityIds,
        );
    }
}
