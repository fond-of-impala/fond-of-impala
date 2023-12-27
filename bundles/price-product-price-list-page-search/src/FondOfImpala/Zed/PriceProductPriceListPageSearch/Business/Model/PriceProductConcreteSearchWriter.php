<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManagerInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepositoryInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceProductConcreteSearchWriter extends AbstractPriceProductSearchWriter implements PriceProductConcreteSearchWriterInterface
{
    protected PriceProductConcreteSearchExpanderInterface $priceProductConcreteSearchExpander;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceGrouperInterface $priceGrouper
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductSearchMapperInterface $priceProductSearchMapper
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface $utilEncodingService
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepositoryInterface $repository
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManagerInterface $entityManager
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchExpanderInterface $priceProductConcreteSearchExpander
     */
    public function __construct(
        PriceGrouperInterface $priceGrouper,
        PriceProductSearchMapperInterface $priceProductSearchMapper,
        PriceProductPriceListPageSearchToUtilEncodingServiceInterface $utilEncodingService,
        PriceProductPriceListPageSearchRepositoryInterface $repository,
        PriceProductPriceListPageSearchEntityManagerInterface $entityManager,
        PriceProductConcreteSearchExpanderInterface $priceProductConcreteSearchExpander
    ) {
        parent::__construct(
            $priceGrouper,
            $priceProductSearchMapper,
            $utilEncodingService,
            $repository,
            $entityManager,
        );

        $this->priceProductConcreteSearchExpander = $priceProductConcreteSearchExpander;
    }

    /**
     * @param array<int> $priceProductPriceListIds
     *
     * @return void
     */
    public function publishConcretePriceProductPriceList(array $priceProductPriceListIds): void
    {
        $priceProductPriceListPageSearchTransfers = $this->repository
            ->findPriceListProductConcretePricesDataByIds($priceProductPriceListIds);

        if (!$priceProductPriceListPageSearchTransfers) {
            return;
        }

        $priceKeys = array_map(
            static fn (PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer) => $priceProductPriceListPageSearchTransfer->getPriceKey(),
            $priceProductPriceListPageSearchTransfers,
        );

        $existingPageSearchEntities = $this->repository
            ->findExistingPriceProductConcretePriceListEntitiesByPriceKeys($priceKeys);

        $this->write($priceProductPriceListPageSearchTransfers, $existingPageSearchEntities, true);
    }

    /**
     * @param array<int> $productIds
     *
     * @return void
     */
    public function publishConcretePriceProductByProductIds(array $productIds): void
    {
        $priceProductPriceListPageSearchTransfers = $this->repository
            ->findPriceListProductConcretePricesDataByProductIds($productIds);

        $existingPageSearchEntities = $this->repository
            ->findExistingPriceProductConcretePriceListEntitiesByProductIds($productIds);

        $this->write($priceProductPriceListPageSearchTransfers, $existingPageSearchEntities);
    }

    /**
     * @param array<\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer> $priceProductPriceListPageSearchTransfers
     * @param array<\Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch> $existingPageSearchEntities
     * @param bool $mergePrices
     *
     * @return void
     */
    protected function write(
        array $priceProductPriceListPageSearchTransfers,
        array $existingPageSearchEntities,
        bool $mergePrices = false
    ): void {
        $existingPageSearchEntities = $this->mapPageSearchEntitiesByPriceKey($existingPageSearchEntities);

        foreach ($priceProductPriceListPageSearchTransfers as $priceProductPriceListPageSearchTransfer) {
            $priceProductPriceListPageSearchTransfer = $this->groupPrices(
                $priceProductPriceListPageSearchTransfer,
                $existingPageSearchEntities,
                $mergePrices,
            );

            // Skip if no prices, the price entity will be deleted at the end
            if (empty($priceProductPriceListPageSearchTransfer->getPrices())) {
                continue;
            }

            $this->priceProductConcreteSearchExpander->expand($priceProductPriceListPageSearchTransfer);

            $this->addDataAttributes($priceProductPriceListPageSearchTransfer);

            if (isset($existingPageSearchEntities[$priceProductPriceListPageSearchTransfer->getPriceKey()])) {
                $this->entityManager->updatePriceProductConcrete(
                    $priceProductPriceListPageSearchTransfer,
                    $existingPageSearchEntities[$priceProductPriceListPageSearchTransfer->getPriceKey()],
                );

                unset($existingPageSearchEntities[$priceProductPriceListPageSearchTransfer->getPriceKey()]);

                continue;
            }

            $this->entityManager->createPriceProductConcrete(
                $priceProductPriceListPageSearchTransfer,
            );

            unset($existingPageSearchEntities[$priceProductPriceListPageSearchTransfer->getPriceKey()]);
        }

        // Delete the rest of the entities
        $this->entityManager->deletePriceProductConcreteEntities($existingPageSearchEntities);
    }

    /**
     * @param array<\Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch> $priceProductConcretePriceListPageSearchEntities
     *
     * @return array
     */
    protected function mapPageSearchEntitiesByPriceKey(array $priceProductConcretePriceListPageSearchEntities): array
    {
        $mappedPriceProductConcretePriceListPageSearchEntities = [];

        foreach ($priceProductConcretePriceListPageSearchEntities as $priceProductConcretePriceListPageSearchEntity) {
            $mappedPriceProductConcretePriceListPageSearchEntities[$priceProductConcretePriceListPageSearchEntity->getPriceKey()] = $priceProductConcretePriceListPageSearchEntity;
        }

        return $mappedPriceProductConcretePriceListPageSearchEntities;
    }

    /**
     * @param int $idPriceList
     *
     * @return void
     */
    public function publishConcretePriceProductPriceListByIdPriceList(int $idPriceList): void
    {
        $priceProductPriceListPageSearchTransfers = $this->repository
            ->findPriceProductConcretePriceListByIdPriceList($idPriceList);

        if (!$priceProductPriceListPageSearchTransfers) {
            return;
        }

        $priceKeys = array_map(
            static fn(PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer) => $priceProductPriceListPageSearchTransfer->getPriceKey(),
            $priceProductPriceListPageSearchTransfers,
        );

        $existingPageSearchEntities = $this->repository
            ->findExistingPriceProductConcretePriceListEntitiesByPriceKeys($priceKeys);

        $this->write($priceProductPriceListPageSearchTransfers, $existingPageSearchEntities, true);
    }
}
