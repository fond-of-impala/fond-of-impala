<?php

namespace FondOfImpala\Zed\PriceListApi\Business\Hydrator;

use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiRepositoryInterface;

class PriceProductsHydrator implements PriceProductsHydratorInterface
{
    /**
     * @var string
     */
    protected const GROUPED_KEY_ABSTRACT = 'abstract';

    /**
     * @var string
     */
    protected const GROUPED_KEY_CONCRETE = 'concrete';

    protected PriceListApiToProductFacadeInterface $productFacade;

    protected PriceListApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeInterface $productFacade
     * @param \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiRepositoryInterface $repository
     */
    public function __construct(
        PriceListApiToProductFacadeInterface $productFacade,
        PriceListApiRepositoryInterface $repository
    ) {
        $this->productFacade = $productFacade;
        $this->repository = $repository;
    }

    /**
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function hydrate(array $priceProductTransfers): array
    {
        $groupedPriceProductTransfers = $this->groupPriceProducts($priceProductTransfers);
        $groupedPriceProductTransfers = $this->hydrateWithProductAbstractIds($groupedPriceProductTransfers);
        $this->hydrateWithProductConcreteIds($groupedPriceProductTransfers);

        return $priceProductTransfers;
    }

    /**
     * @param array<string, array<string, \Generated\Shared\Transfer\PriceProductTransfer>> $groupedPriceProductTransfers
     *
     * @return array<string, array<string, \Generated\Shared\Transfer\PriceProductTransfer>>
     */
    protected function hydrateWithProductAbstractIds(array $groupedPriceProductTransfers): array
    {
        $skus = array_keys($groupedPriceProductTransfers[static::GROUPED_KEY_ABSTRACT]);

        if (!$skus) {
            return $groupedPriceProductTransfers;
        }

        $productIds = $this->repository->getProductAbstractIdsByAbstractSkus($skus);

        foreach ($productIds as $sku => $productId) {
            if (empty($groupedPriceProductTransfers[static::GROUPED_KEY_ABSTRACT][$sku])) {
                continue;
            }

            $groupedPriceProductTransfers[static::GROUPED_KEY_ABSTRACT][$sku]->setIdProductAbstract($productId);
        }

        return $groupedPriceProductTransfers;
    }

    /**
     * @param array<string, array<string, \Generated\Shared\Transfer\PriceProductTransfer>> $groupedPriceProductTransfers
     *
     * @return array<string, array<string, \Generated\Shared\Transfer\PriceProductTransfer>>
     */
    protected function hydrateWithProductConcreteIds(array $groupedPriceProductTransfers): array
    {
        $skus = array_keys($groupedPriceProductTransfers[static::GROUPED_KEY_CONCRETE]);

        if (!$skus) {
            return $groupedPriceProductTransfers;
        }

        $productIds = $this->productFacade->getProductConcreteIdsByConcreteSkus($skus);

        foreach ($productIds as $sku => $productId) {
            if (empty($groupedPriceProductTransfers[static::GROUPED_KEY_CONCRETE][$sku])) {
                continue;
            }

            $groupedPriceProductTransfers[static::GROUPED_KEY_CONCRETE][$sku]->setIdProduct($productId);
        }

        return $groupedPriceProductTransfers;
    }

    /**
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return array<string, array<string, \Generated\Shared\Transfer\PriceProductTransfer>>
     */
    protected function groupPriceProducts(array $priceProductTransfers): array
    {
        $groupedPriceProductTransfers = [
            static::GROUPED_KEY_ABSTRACT => [],
            static::GROUPED_KEY_CONCRETE => [],
        ];

        foreach ($priceProductTransfers as $priceProductTransfer) {
            $sku = $priceProductTransfer->getSkuProduct();

            if ($sku !== null && $priceProductTransfer->getIdProduct() === null) {
                $groupedPriceProductTransfers[static::GROUPED_KEY_CONCRETE][$sku] = $priceProductTransfer;

                continue;
            }

            $sku = $priceProductTransfer->getSkuProductAbstract();

            if ($sku !== null && $priceProductTransfer->getIdProductAbstract() === null) {
                $groupedPriceProductTransfers[static::GROUPED_KEY_ABSTRACT][$sku] = $priceProductTransfer;
            }
        }

        return $groupedPriceProductTransfers;
    }
}
