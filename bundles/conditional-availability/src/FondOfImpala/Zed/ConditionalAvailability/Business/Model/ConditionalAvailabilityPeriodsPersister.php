<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use DateTime;
use FondOfImpala\Zed\ConditionalAvailability\Business\Generator\KeyGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityPeriodsPersister implements ConditionalAvailabilityPeriodsPersisterInterface
{
    protected KeyGeneratorInterface $keyGenerator;

    protected ConditionalAvailabilityEntityManagerInterface $entityManager;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailability\Business\Generator\KeyGeneratorInterface $keyGenerator
     * @param \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface $entityManager
     */
    public function __construct(
        KeyGeneratorInterface $keyGenerator,
        ConditionalAvailabilityEntityManagerInterface $entityManager
    ) {
        $this->keyGenerator = $keyGenerator;
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function persist(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityTransfer {
        if (
            $conditionalAvailabilityTransfer->getIdConditionalAvailability() === null
            || $conditionalAvailabilityTransfer->getConditionalAvailabilityPeriodCollection() === null
        ) {
            return $conditionalAvailabilityTransfer;
        }

        $this->entityManager->deleteConditionalAvailabilityPeriodsByConditionalAvailabilityId(
            $conditionalAvailabilityTransfer->getIdConditionalAvailability(),
        );

        $conditionalAvailabilityPeriodTransfers = $conditionalAvailabilityTransfer
            ->getConditionalAvailabilityPeriodCollection()
            ->getConditionalAvailabilityPeriods();

        $now = new DateTime();

        foreach ($conditionalAvailabilityPeriodTransfers as $conditionalAvailabilityPeriodTransfer) {
            $fkConditionalAvailability = $conditionalAvailabilityTransfer->getIdConditionalAvailability();
            $key = $this->keyGenerator->generate($conditionalAvailabilityPeriodTransfer, $now);

            $conditionalAvailabilityPeriodTransfer->setKey($key)
                ->setFkConditionalAvailability($fkConditionalAvailability)
                ->setCreatedAt($now->format('Y-m-d H:i:s.u'));

            $this->entityManager->createConditionalAvailabilityPeriod($conditionalAvailabilityPeriodTransfer);
        }

        return $conditionalAvailabilityTransfer;
    }
}
