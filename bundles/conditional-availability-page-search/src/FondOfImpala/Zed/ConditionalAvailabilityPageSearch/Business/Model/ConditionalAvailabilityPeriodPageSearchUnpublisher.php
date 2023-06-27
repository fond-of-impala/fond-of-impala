<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface;

class ConditionalAvailabilityPeriodPageSearchUnpublisher implements ConditionalAvailabilityPeriodPageSearchUnpublisherInterface
{
    protected ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager
     */
    public function __construct(ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function unpublish(array $conditionalAvailabilityIds): void
    {
        $this->entityManager->deleteConditionalAvailabilityPeriodSearchPagesByConditionalAvailabilityIds(
            $conditionalAvailabilityIds,
        );
    }
}
