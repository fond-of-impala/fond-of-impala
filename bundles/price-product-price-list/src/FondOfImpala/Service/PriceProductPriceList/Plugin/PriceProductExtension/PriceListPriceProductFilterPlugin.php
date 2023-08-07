<?php

namespace FondOfImpala\Service\PriceProductPriceList\Plugin\PriceProductExtension;

use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use Generated\Shared\Transfer\PriceProductFilterTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Service\Kernel\AbstractPlugin;
use Spryker\Service\PriceProductExtension\Dependency\Plugin\PriceProductFilterPluginInterface;
use Spryker\Shared\PriceProduct\PriceProductConfig;

class PriceListPriceProductFilterPlugin extends AbstractPlugin implements PriceProductFilterPluginInterface
{
    /**
     * Specification:
     * - Filters passed prices by the additional business logic
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     * @param \Generated\Shared\Transfer\PriceProductFilterTransfer $priceProductFilterTransfer
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function filter(array $priceProductTransfers, PriceProductFilterTransfer $priceProductFilterTransfer): array
    {
        $priceProductFilterTransfer->requirePriceMode();

        $resultPriceProductTransfers = [];
        $minPriceProductTransfer = null;

        foreach ($priceProductTransfers as $priceProductTransfer) {
            $priceProductTransfer->requirePriceDimension();

            if (!$priceProductTransfer->getPriceDimension()->getIdPriceList()) {
                $resultPriceProductTransfers[] = $priceProductTransfer;
            }

            if ($minPriceProductTransfer === null || !$this->hasPriceByPriceMode($minPriceProductTransfer, $priceProductFilterTransfer->getPriceMode())) {
                $minPriceProductTransfer = $priceProductTransfer;

                continue;
            }

            if (!$this->hasPriceByPriceMode($priceProductTransfer, $priceProductFilterTransfer->getPriceMode())) {
                continue;
            }

            if ($priceProductFilterTransfer->getPriceMode() === PriceProductConfig::PRICE_GROSS_MODE) {
                if ($minPriceProductTransfer->getMoneyValue()->getGrossAmount() > $priceProductTransfer->getMoneyValue()->getGrossAmount()) {
                    $minPriceProductTransfer = $priceProductTransfer;
                }

                continue;
            }

            if ($minPriceProductTransfer->getMoneyValue()->getNetAmount() > $priceProductTransfer->getMoneyValue()->getNetAmount()) {
                $minPriceProductTransfer = $priceProductTransfer;
            }
        }

        foreach ($priceProductTransfers as $priceProductTransfer) {
            if ($minPriceProductTransfer->getPriceDimension()->getIdPriceList() === $priceProductTransfer->getPriceDimension()->getIdPriceList()) {
                $resultPriceProductTransfers[] = $priceProductTransfer;
            }
        }

        return $resultPriceProductTransfers;
    }

    /**
     * Specification:
     *  - Returns dimension name.
     *
     * @api
     *
     * @return string
     */
    public function getDimensionName(): string
    {
        return PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param string $priceMode
     *
     * @return bool
     */
    protected function hasPriceByPriceMode(PriceProductTransfer $priceProductTransfer, string $priceMode): bool
    {
        return ($priceMode === PriceProductConfig::PRICE_GROSS_MODE && $priceProductTransfer->getMoneyValue()->getGrossAmount() !== null) ||
            ($priceMode !== PriceProductConfig::PRICE_GROSS_MODE && $priceProductTransfer->getMoneyValue()->getNetAmount() !== null);
    }
}
