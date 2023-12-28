<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageDataExpanderPluginInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductConcreteSearchExpanderTest extends Unit
{
    /**
     * @var array<\FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageDataExpanderPluginInterface>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $priceProductConcretePriceListPageDataExpanderPluginMocks;

    protected MockObject|PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransferMock;

    protected PriceProductConcreteSearchExpander $priceProductConcreteSearchExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductConcretePriceListPageDataExpanderPluginMocks = [
            $this->getMockBuilder(PriceProductConcretePriceListPageDataExpanderPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->priceProductPriceListPageSearchTransferMock = $this->getMockBuilder(PriceProductPriceListPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductConcreteSearchExpander = new PriceProductConcreteSearchExpander(
            $this->priceProductConcretePriceListPageDataExpanderPluginMocks,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->priceProductConcretePriceListPageDataExpanderPluginMocks[0]->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->priceProductPriceListPageSearchTransferMock)
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $priceProductPriceListPageSearchTransfer = $this->priceProductConcreteSearchExpander
            ->expand($this->priceProductPriceListPageSearchTransferMock);

        static::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $priceProductPriceListPageSearchTransfer,
        );
    }
}
