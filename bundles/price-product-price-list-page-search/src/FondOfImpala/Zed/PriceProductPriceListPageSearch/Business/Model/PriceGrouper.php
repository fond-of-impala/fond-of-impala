<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceGrouper implements PriceGrouperInterface
{
    /**
     * @var string
     */
    protected const PRICES = 'prices';

    /**
     * @var string
     */
    protected const PRICE_DATA = 'price_data';

    /**
     * @var string
     */
    protected const PRICE_MODE_GROSS = 'GROSS_MODE';

    /**
     * @var string
     */
    protected const PRICE_MODE_NET = 'NET_MODE';

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     * @param array $existingPricesData
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function groupPricesData(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer,
        array $existingPricesData = []
    ): PriceProductPriceListPageSearchTransfer {
        $groupedPrices = $this->groupPrices($priceProductPriceListPageSearchTransfer);

        if (isset($existingPricesData[static::PRICES])) {
            $groupedPrices = array_replace_recursive($existingPricesData[static::PRICES], $groupedPrices);
        }

        $groupedPrices = $this->filterPriceData($groupedPrices, static::PRICE_DATA);

        return $priceProductPriceListPageSearchTransfer->setPrices(
            $this->formatData($groupedPrices),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return array
     */
    protected function groupPrices(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): array {
        $groupedPrices = [];

        foreach ($priceProductPriceListPageSearchTransfer->getUngroupedPrices() as $priceTransfer) {
            $currencyCode = $priceTransfer->getCurrencyCode();

            if ($priceTransfer->getGrossPrice() !== null || $priceTransfer->getNetPrice() !== null) {
                $groupedPrices[$currencyCode][static::PRICE_DATA] = $priceTransfer->getPriceData();
            }

            $priceType = $priceTransfer->getPriceType();

            $groupedPrices[$currencyCode][static::PRICE_MODE_GROSS][$priceType] = $priceTransfer->getGrossPrice();
            $groupedPrices[$currencyCode][static::PRICE_MODE_NET][$priceType] = $priceTransfer->getNetPrice();
        }

        return $groupedPrices;
    }

    /**
     * @param array $priceData
     * @param string $excludeKey
     *
     * @return array
     */
    protected function filterPriceData(array $priceData, string $excludeKey): array
    {
        $priceData = array_filter($priceData, function ($v, $k) use ($excludeKey) {
            if ($k === $excludeKey) {
                return true;
            }

            return $v !== null;
        }, ARRAY_FILTER_USE_BOTH);

        foreach ($priceData as $key => &$value) {
            if (is_array($value)) {
                $value = $this->filterPriceData($value, $excludeKey);

                if (!$value || $value === [$excludeKey => null]) {
                    unset($priceData[$key]);
                }
            }
        }

        return $priceData;
    }

    /**
     * @param array $prices
     *
     * @return array
     */
    protected function formatData(array $prices): array
    {
        if ($prices) {
            return $prices;
        }

        return [];
    }
}
