<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Persistence;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriod;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityPersistenceFactory getFactory()
 */
class ConditionalAvailabilityEntityManager extends AbstractEntityManager implements ConditionalAvailabilityEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function persistConditionalAvailability(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityTransfer {
        $foiConditionalAvailabilityQuery = $this->getFactory()->createConditionalAvailabilityQuery();

        if ($conditionalAvailabilityTransfer->getIdConditionalAvailability() !== null) {
            $foiConditionalAvailability = $foiConditionalAvailabilityQuery
                ->filterByIdConditionalAvailability($conditionalAvailabilityTransfer->getIdConditionalAvailability())
                ->findOneOrCreate();
        } else {
            $foiConditionalAvailability = $foiConditionalAvailabilityQuery
                ->filterByFkProduct($conditionalAvailabilityTransfer->getFkProduct())
                ->filterByWarehouseGroup($conditionalAvailabilityTransfer->getWarehouseGroup())
                ->findOneOrCreate();
        }

        $foiConditionalAvailability = $this->getFactory()
            ->createConditionalAvailabilityMapper()
            ->mapTransferToEntity($conditionalAvailabilityTransfer, $foiConditionalAvailability);

        $foiConditionalAvailability->save();

        $conditionalAvailabilityTransfer->setIdConditionalAvailability(
            $foiConditionalAvailability->getIdConditionalAvailability(),
        );

        return $conditionalAvailabilityTransfer;
    }

    /**
     * @param int $idConditionalAvailability
     *
     * @return void
     */
    public function deleteConditionalAvailabilityById(int $idConditionalAvailability): void
    {
        $this->getFactory()
            ->createConditionalAvailabilityQuery()
            ->filterByIdConditionalAvailability($idConditionalAvailability)
            ->delete();
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer
     */
    public function createConditionalAvailabilityPeriod(
        ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
    ): ConditionalAvailabilityPeriodTransfer {
        $foiConditionalAvailabilityPeriod = $this->getFactory()
            ->createConditionalAvailabilityPeriodMapper()
            ->mapTransferToEntity(
                $conditionalAvailabilityPeriodTransfer,
                new FoiConditionalAvailabilityPeriod(),
            );

        $foiConditionalAvailabilityPeriod->save();

        return $conditionalAvailabilityPeriodTransfer;
    }

    /**
     * @param int $idConditionalAvailability
     *
     * @return void
     */
    public function deleteConditionalAvailabilityPeriodsByConditionalAvailabilityId(int $idConditionalAvailability): void
    {
        $foiConditionalAvailabilityPeriodQuery = $this->getFactory()->createConditionalAvailabilityPeriodQuery();

        $foiConditionalAvailabilityPeriods = $foiConditionalAvailabilityPeriodQuery
            ->filterByFkConditionalAvailability($idConditionalAvailability)
            ->find();

        foreach ($foiConditionalAvailabilityPeriods as $foiConditionalAvailabilityPeriod) {
            $foiConditionalAvailabilityPeriod->delete();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function saveConditionalAvailability(ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer): ConditionalAvailabilityTransfer
    {
        $foiConditionalAvailabilityQuery = $this->getFactory()->createConditionalAvailabilityQuery();

        $foiConditionalAvailability = $foiConditionalAvailabilityQuery
            ->filterByIdConditionalAvailability($conditionalAvailabilityTransfer->getIdConditionalAvailability())
            ->findOneOrCreate();

        $foiConditionalAvailability = $this->getFactory()
            ->createConditionalAvailabilityMapper()
            ->mapTransferToEntity($conditionalAvailabilityTransfer, $foiConditionalAvailability);

        $foiConditionalAvailability->save();

        $conditionalAvailabilityTransfer->setIdConditionalAvailability(
            $foiConditionalAvailability->getIdConditionalAvailability(),
        );

        return $conditionalAvailabilityTransfer;
    }
}
