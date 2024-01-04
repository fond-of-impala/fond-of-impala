<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Business;

use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityRepositoryInterface getRepository()
 */
class AllowedProductQuantityFacade extends AbstractFacade implements AllowedProductQuantityFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function persistProductAbstractAllowedQuantity(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $this->getFactory()->createProductAbstractAllowedQuantityWriter()->persist($productAbstractTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer
     */
    public function findProductAbstractAllowedQuantity(ProductAbstractTransfer $productAbstractTransfer): AllowedProductQuantityResponseTransfer
    {
        return $this->getFactory()->createProductAbstractAllowedQuantityReader()->findByIdProductAbstract($productAbstractTransfer);
    }

    /**
     * @param array<string> $abstractSkus
     *
     * @return array<string, \Generated\Shared\Transfer\AllowedProductQuantityTransfer>
     */
    public function findGroupedProductAbstractAllowedQuantitiesByAbstractSkus(array $abstractSkus): array
    {
        return $this->getRepository()->findGroupedAllowedProductQuantitiesByAbstractSkus($abstractSkus);
    }
}
