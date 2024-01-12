<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider;

use FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class AllowedQuantityFormDataProvider
{
    protected AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface $allowedProductQuantityFacade;

    /**
     * @param \FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface $allowedProductQuantityFacade
     */
    public function __construct(AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface $allowedProductQuantityFacade)
    {
        $this->allowedProductQuantityFacade = $allowedProductQuantityFacade;
    }

    /**
     * @param int|null $idProductAbstract
     *
     * @return array
     */
    public function getOptions(?int $idProductAbstract = null): array
    {
        if ($idProductAbstract === null) {
            return [];
        }

        $productAbstractTransfer = (new ProductAbstractTransfer())->setIdProductAbstract($idProductAbstract);

        $allowedProductQuantityResponseTransfer = $this->allowedProductQuantityFacade
            ->findProductAbstractAllowedQuantity($productAbstractTransfer);

        if ($allowedProductQuantityResponseTransfer->getIsSuccessful() === false) {
            return [];
        }

        $allowedProductQuantityTransfer = $allowedProductQuantityResponseTransfer->getAllowedProductQuantityTransfer();

        return $allowedProductQuantityTransfer->toArray();
    }
}
