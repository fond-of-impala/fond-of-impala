<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer;
use Generated\Shared\Transfer\RestPriceProductPriceListSearchPricesTransfer;

abstract class AbstractPriceProductPriceListSearchResourceMapper implements PriceProductPriceListSearchResourceMapperInterface
{
    /**
     * @param array $restSearchResponse
     *
     * @return \Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer
     */
    public function mapRestSearchResponseToRestAttributesTransfer(array $restSearchResponse): RestPriceProductPriceListSearchAttributesTransfer
    {
        $restSearchAttributesTransfer = (new RestPriceProductPriceListSearchAttributesTransfer())
            ->fromArray($restSearchResponse, true);

        $restSearchAttributesTransfer = $this->addPrices(
            $restSearchAttributesTransfer,
            $restSearchResponse,
        );

        return $restSearchAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer $restSearchAttributesTransfer
     * @param array $restSearchResponse
     *
     * @return \Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer
     */
    protected function addPrices(
        RestPriceProductPriceListSearchAttributesTransfer $restSearchAttributesTransfer,
        array $restSearchResponse
    ): RestPriceProductPriceListSearchAttributesTransfer {
        $pricesSearchKey = $this->getPricesSearchKey();

        if (!isset($restSearchResponse[$pricesSearchKey]) || !is_array($restSearchResponse[$pricesSearchKey])) {
            return $restSearchAttributesTransfer;
        }

        foreach ($restSearchResponse[$pricesSearchKey] as $price) {
            $restSearchAttributesTransfer->addPrice(
                (new RestPriceProductPriceListSearchPricesTransfer())->fromArray($price, true),
            );
        }

        return $restSearchAttributesTransfer;
    }

    /**
     * @return string
     */
    abstract protected function getPricesSearchKey(): string;
}
