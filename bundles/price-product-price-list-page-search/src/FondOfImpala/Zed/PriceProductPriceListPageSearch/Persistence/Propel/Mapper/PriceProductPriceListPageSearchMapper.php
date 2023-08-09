<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchValueTransfer;

class PriceProductPriceListPageSearchMapper implements PriceProductPriceListPageSearchMapperInterface
{
    /**
     * @var string
     */
    protected const PRICE_KEY_SEPARATOR = ':';

    /**
     * @param array $priceProductPriceListsData
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function mapDataArrayToTransferArray(array $priceProductPriceListsData): array
    {
        $pricesByKey = [];

        foreach ($priceProductPriceListsData as $priceProductPriceListData) {
            $uniquePriceIndex = $this->createUniquePriceIndex($priceProductPriceListData);

            if (!isset($pricesByKey[$uniquePriceIndex])) {
                $pricesByKey[$uniquePriceIndex] = $this->createPriceProductPriceListPageSearchTransfer(
                    $priceProductPriceListData,
                    $uniquePriceIndex,
                );
            }

            $this->addUngroupedPrice($pricesByKey[$uniquePriceIndex], $priceProductPriceListData);
        }

        return $pricesByKey;
    }

    /**
     * @param array $priceProductPriceListData
     *
     * @return string
     */
    protected function createUniquePriceIndex(array $priceProductPriceListData): string
    {
        return implode(static::PRICE_KEY_SEPARATOR, [
            $priceProductPriceListData[PriceProductPriceListPageSearchTransfer::STORE_NAME],
            $priceProductPriceListData[PriceProductPriceListPageSearchTransfer::ID_PRODUCT],
            $priceProductPriceListData[PriceProductPriceListPageSearchTransfer::ID_PRICE_LIST],
        ]);
    }

    /**
     * @param array $priceProductPriceListData
     * @param string $uniquePriceIndex
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected function createPriceProductPriceListPageSearchTransfer(
        array $priceProductPriceListData,
        string $uniquePriceIndex
    ): PriceProductPriceListPageSearchTransfer {
        return (new PriceProductPriceListPageSearchTransfer())
            ->fromArray($priceProductPriceListData, true)
            ->setPriceKey($uniquePriceIndex);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     * @param array $priceProductPriceListData
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected function addUngroupedPrice(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer,
        array $priceProductPriceListData
    ): PriceProductPriceListPageSearchTransfer {
        return $priceProductPriceListPageSearchTransfer->addUngroupedPrice(
            (new PriceProductPriceListPageSearchValueTransfer())
                ->fromArray($priceProductPriceListData, true),
        );
    }
}
