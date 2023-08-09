<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManagerInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepositoryInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceProductAbstractSearchWriter extends AbstractPriceProductSearchWriter implements PriceProductAbstractSearchWriterInterface
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchExpanderInterface
     */
    protected $priceProductAbstractSearchExpander;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceGrouperInterface $priceGrouper
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductSearchMapperInterface $priceProductSearchMapper
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface $utilEncodingService
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepositoryInterface $repository
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManagerInterface $entityManager
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchExpanderInterface $priceProductAbstractSearchExpander
     */
    public function __construct(
        PriceGrouperInterface $priceGrouper,
        PriceProductSearchMapperInterface $priceProductSearchMapper,
        PriceProductPriceListPageSearchToUtilEncodingServiceInterface $utilEncodingService,
        PriceProductPriceListPageSearchRepositoryInterface $repository,
        PriceProductPriceListPageSearchEntityManagerInterface $entityManager,
        PriceProductAbstractSearchExpanderInterface $priceProductAbstractSearchExpander
    ) {
        parent::__construct(
            $priceGrouper,
            $priceProductSearchMapper,
            $utilEncodingService,
            $repository,
            $entityManager,
        );

        $this->priceProductAbstractSearchExpander = $priceProductAbstractSearchExpander;
    }

    /**
     * @param int[] $priceProductPriceListIds
     *
     * @return void
     */
    public function publishAbstractPriceProductPriceList(array $priceProductPriceListIds): void
    {
        $priceProductPriceListPageSearchTransfers = $this->repository
            ->findPriceProductPriceListByIds($priceProductPriceListIds);

        if (!$priceProductPriceListPageSearchTransfers) {
            return;
        }

        $priceKeys = array_map(
            function (PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer) {
                return $priceProductPriceListPageSearchTransfer->getPriceKey();
            },
            $priceProductPriceListPageSearchTransfers,
        );

        $existingPageSearchEntities = $this->repository
            ->findExistingPriceProductAbstractPriceListEntitiesByPriceKeys($priceKeys);

        $this->write($priceProductPriceListPageSearchTransfers, $existingPageSearchEntities, true);
    }

    /**
     * @param int[] $productAbstractIds
     *
     * @return void
     */
    public function publishAbstractPriceProductByByProductAbstractIds(array $productAbstractIds): void
    {
        $priceProductPriceListPageSearchTransfers = $this->repository
            ->findPriceListProductAbstractPricesDataByProductAbstractIds($productAbstractIds);

        $existingPageSearchEntities = $this->repository
            ->findExistingPriceProductAbstractPriceListEntitiesByProductAbstractIds($productAbstractIds);

        $this->write($priceProductPriceListPageSearchTransfers, $existingPageSearchEntities);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[] $priceProductPriceListPageSearchTransfers
     * @param \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch[] $existingPageSearchEntities
     * @param bool $mergePrices
     *
     * @return void
     */
    protected function write(
        array $priceProductPriceListPageSearchTransfers,
        array $existingPageSearchEntities = [],
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

            $this->priceProductAbstractSearchExpander
                ->expand($priceProductPriceListPageSearchTransfer);

            $this->addDataAttributes($priceProductPriceListPageSearchTransfer);

            if (isset($existingPageSearchEntities[$priceProductPriceListPageSearchTransfer->getPriceKey()])) {
                $this->entityManager->updatePriceProductAbstract(
                    $priceProductPriceListPageSearchTransfer,
                    $existingPageSearchEntities[$priceProductPriceListPageSearchTransfer->getPriceKey()],
                );
                unset($existingPageSearchEntities[$priceProductPriceListPageSearchTransfer->getPriceKey()]);

                continue;
            }

            $this->entityManager->createPriceProductAbstract(
                $priceProductPriceListPageSearchTransfer,
            );

            unset($existingPageSearchEntities[$priceProductPriceListPageSearchTransfer->getPriceKey()]);
        }

        // Delete the rest of the entities
        $this->entityManager->deletePriceProductAbstractEntities($existingPageSearchEntities);
    }

    /**
     * @param \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch[] $priceProductAbstractPriceListPageSearchEntities
     *
     * @return array
     */
    protected function mapPageSearchEntitiesByPriceKey(array $priceProductAbstractPriceListPageSearchEntities): array
    {
        $mappedPriceProductAbstractPriceListPageSearchEntities = [];

        foreach ($priceProductAbstractPriceListPageSearchEntities as $priceProductAbstractPriceListPageSearchEntity) {
            $mappedPriceProductAbstractPriceListPageSearchEntities[$priceProductAbstractPriceListPageSearchEntity->getPriceKey()] = $priceProductAbstractPriceListPageSearchEntity;
        }

        return $mappedPriceProductAbstractPriceListPageSearchEntities;
    }

    /**
     * @param int $idPriceList
     *
     * @return void
     */
    public function publishAbstractPriceProductPriceListByIdPriceList(int $idPriceList): void
    {
        $priceProductPriceListPageSearchTransfers = $this->repository
            ->findPriceProductAbstractPriceListByIdPriceList($idPriceList);

        if (!$priceProductPriceListPageSearchTransfers) {
            return;
        }

        $priceKeys = array_map(
            function (PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer) {
                return $priceProductPriceListPageSearchTransfer->getPriceKey();
            },
            $priceProductPriceListPageSearchTransfers,
        );

        $existingPageSearchEntities = $this->repository
            ->findExistingPriceProductAbstractPriceListEntitiesByPriceKeys($priceKeys);

        $this->write($priceProductPriceListPageSearchTransfers, $existingPageSearchEntities, true);
    }
}
