<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer;

class PriceProductConcretePriceListSearchResourceMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductConcretePriceListSearchResourceMapper
     */
    protected $priceProductConcretePriceListSearchResourceMapper;

    /**
     * @var array
     */
    protected $restSearchResponse;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restSearchResponse = [
            'price_product_concrete_price_lists' => [
                [],
            ],
        ];

        $this->priceProductConcretePriceListSearchResourceMapper = new PriceProductConcretePriceListSearchResourceMapper();
    }

    /**
     * @return void
     */
    public function testMapRestSearchResponseToRestAttributesTransfer(): void
    {
        $this->assertInstanceOf(
            RestPriceProductPriceListSearchAttributesTransfer::class,
            $this->priceProductConcretePriceListSearchResourceMapper->mapRestSearchResponseToRestAttributesTransfer(
                $this->restSearchResponse,
            ),
        );
    }
}
