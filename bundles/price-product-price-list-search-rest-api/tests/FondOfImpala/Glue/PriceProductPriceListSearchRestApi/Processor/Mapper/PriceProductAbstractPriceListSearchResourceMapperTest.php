<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer;

class PriceProductAbstractPriceListSearchResourceMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductAbstractPriceListSearchResourceMapper
     */
    protected PriceProductAbstractPriceListSearchResourceMapper $priceProductAbstractPriceListSearchResourceMapper;

    /**
     * @var array
     */
    protected array $restSearchResponse;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restSearchResponse = [
            'price_product_abstract_price_lists' => [
                [],
            ],
        ];

        $this->priceProductAbstractPriceListSearchResourceMapper = new PriceProductAbstractPriceListSearchResourceMapper();
    }

    /**
     * @return void
     */
    public function testGetPricesSearchKey(): void
    {
        static::assertInstanceOf(
            RestPriceProductPriceListSearchAttributesTransfer::class,
            $this->priceProductAbstractPriceListSearchResourceMapper->mapRestSearchResponseToRestAttributesTransfer(
                $this->restSearchResponse,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetPricesSearchKeyNoArray(): void
    {
        static::assertInstanceOf(
            RestPriceProductPriceListSearchAttributesTransfer::class,
            $this->priceProductAbstractPriceListSearchResourceMapper->mapRestSearchResponseToRestAttributesTransfer(
                [],
            ),
        );
    }
}
