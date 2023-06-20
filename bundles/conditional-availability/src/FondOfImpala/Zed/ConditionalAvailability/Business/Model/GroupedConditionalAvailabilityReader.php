<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use ArrayObject;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;

class GroupedConditionalAvailabilityReader implements GroupedConditionalAvailabilityReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface $repository
     */
    public function __construct(ConditionalAvailabilityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>
     */
    public function find(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ArrayObject {
        return $this->repository->findGroupedConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);
    }
}
