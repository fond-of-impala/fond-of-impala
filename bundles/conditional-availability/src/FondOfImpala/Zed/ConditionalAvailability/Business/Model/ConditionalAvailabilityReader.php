<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityReader implements ConditionalAvailabilityReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface $repository
     */
    public function __construct(
        ConditionalAvailabilityRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function findById(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer {
        $conditionalAvailabilityTransfer->requireIdConditionalAvailability();

        $conditionalAvailabilityTransfer = $this->repository->findConditionalAvailabilityById(
            $conditionalAvailabilityTransfer->getIdConditionalAvailability(),
        );

        $conditionalAvailabilityResponseTransfer = (new ConditionalAvailabilityResponseTransfer())
            ->setIsSuccessful(true)
            ->setConditionalAvailabilityTransfer($conditionalAvailabilityTransfer);

        if ($conditionalAvailabilityTransfer === null) {
            return $conditionalAvailabilityResponseTransfer->setIsSuccessful(false);
        }

        return $conditionalAvailabilityResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function findAll(): ConditionalAvailabilityCollectionTransfer
    {
        $conditionalAvailabilityCriteriaFilterTransfer = new ConditionalAvailabilityCriteriaFilterTransfer();

        return $this->find($conditionalAvailabilityCriteriaFilterTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function find(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ConditionalAvailabilityCollectionTransfer {
        return $this->repository->findConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);
    }
}
