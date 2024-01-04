<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\Plugin\ProductPageSearch;

use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\AllowedProductQuantitySearchCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\AllowedProductQuantitySearchConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\Business\AllowedProductQuantitySearchFacadeInterface getFacade()
 */
class AllowedQuantityProductPageDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(
        array $productData,
        ProductPageSearchTransfer $productAbstractPageSearchTransfer
    ): void {
        $idProductAbstract = $productAbstractPageSearchTransfer->getIdProductAbstract();

        if ($idProductAbstract === null) {
            return;
        }

        $productAbstractTransfer = (new ProductAbstractTransfer())->setIdProductAbstract($idProductAbstract);

         $allowedProductQuantityResponseTransfer = $this->getFactory()->getAllowedProductQuantityFacade()
            ->findProductAbstractAllowedQuantity($productAbstractTransfer);

        $allowedProductQuantityTransfer = $allowedProductQuantityResponseTransfer->getAllowedProductQuantityTransfer();

        if ($allowedProductQuantityTransfer === null) {
            $allowedProductQuantityTransfer = new AllowedProductQuantityTransfer();
        }

        $productAbstractPageSearchTransfer->setAllowedQuantity(
            $this->mapAllowedProductQuantityTransferToAllowedQuantityArray($allowedProductQuantityTransfer),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\AllowedProductQuantityTransfer $allowedProductQuantityTransfer
     *
     * @return array
     */
    protected function mapAllowedProductQuantityTransferToAllowedQuantityArray(
        AllowedProductQuantityTransfer $allowedProductQuantityTransfer
    ): array {
        $allowedQuantityArray = $allowedProductQuantityTransfer->toArray(true, true);

        if (array_key_exists('idAllowedProductQuantity', $allowedQuantityArray)) {
            unset($allowedQuantityArray['idAllowedProductQuantity']);
        }

        if (array_key_exists('idProductAbstract', $allowedQuantityArray)) {
            unset($allowedQuantityArray['idProductAbstract']);
        }

        return $allowedQuantityArray;
    }
}
