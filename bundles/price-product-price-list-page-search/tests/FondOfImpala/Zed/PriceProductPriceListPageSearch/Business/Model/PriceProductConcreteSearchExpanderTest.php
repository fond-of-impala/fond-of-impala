<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageDataExpanderPluginInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceProductConcreteSearchExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageDataExpanderPluginInterface[]
     */
    protected $priceProductConcretePriceListPageDataExpanderPluginMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected $priceProductPriceListPageSearchTransferMock;

    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchExpander
     */
    protected $priceProductConcreteSearchExpander;

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
        $this->priceProductConcretePriceListPageDataExpanderPluginMocks[0]->expects($this->atLeastOnce())
            ->method('expand')
            ->with($this->priceProductPriceListPageSearchTransferMock)
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $priceProductPriceListPageSearchTransfer = $this->priceProductConcreteSearchExpander
            ->expand($this->priceProductPriceListPageSearchTransferMock);

        $this->assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $priceProductPriceListPageSearchTransfer,
        );
    }
}
