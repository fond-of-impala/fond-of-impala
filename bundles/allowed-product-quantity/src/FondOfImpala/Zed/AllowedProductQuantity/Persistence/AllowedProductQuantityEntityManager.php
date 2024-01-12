<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Persistence;

use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityPersistenceFactory getFactory()
 */
class AllowedProductQuantityEntityManager extends AbstractEntityManager implements AllowedProductQuantityEntityManagerInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\AllowedProductQuantityTransfer $allowedProductQuantityTransfer
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityTransfer
     */
    public function persistAllowedProductQuantity(AllowedProductQuantityTransfer $allowedProductQuantityTransfer): AllowedProductQuantityTransfer
    {
        $query = $this->getFactory()
            ->createAllowedProductQuantityQuery()
            ->clear();

        $entity = $query
            ->filterByIdAllowedProductQuantity($allowedProductQuantityTransfer->getIdAllowedProductQuantity())
            ->findOneOrCreate();

        $entity->fromArray($allowedProductQuantityTransfer->modifiedToArray());

        $entity->setFkProductAbstract($allowedProductQuantityTransfer->getIdProductAbstract())
            ->save();

        return $this->getFactory()
            ->createAllowedProductQuantityMapper()
            ->mapEntityToTransfer($entity);
    }

    /**
     * {@inheritDoc}
     *
     * @param int $idAllowedProductQuantity
     *
     * @return void
     */
    public function deleteAllowedProductQuantityById(int $idAllowedProductQuantity): void
    {
        $entity = $this->getFactory()
            ->createAllowedProductQuantityQuery()
            ->clear()
            ->filterByIdAllowedProductQuantity($idAllowedProductQuantity)
            ->findOne();

        if ($entity !== null) {
            $entity->delete();
        }
    }
}
