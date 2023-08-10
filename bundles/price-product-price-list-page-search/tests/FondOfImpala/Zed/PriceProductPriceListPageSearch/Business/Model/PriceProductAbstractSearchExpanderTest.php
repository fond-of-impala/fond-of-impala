<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageDataExpanderPluginInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceProductAbstractSearchExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageDataExpanderPluginInterface[]
     */
    protected $priceProductAbstractPriceListPageDataExpanderPluginMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected $priceProductPriceListPageSearchTransferMock;

    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchExpander
     */
    protected $priceProductAbstractSearchExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductAbstractPriceListPageDataExpanderPluginMocks = [
            $this->getMockBuilder(PriceProductAbstractPriceListPageDataExpanderPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->priceProductPriceListPageSearchTransferMock = $this->getMockBuilder(PriceProductPriceListPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductAbstractSearchExpander = new PriceProductAbstractSearchExpander(
            $this->priceProductAbstractPriceListPageDataExpanderPluginMocks,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->priceProductAbstractPriceListPageDataExpanderPluginMocks[0]->expects($this->atLeastOnce())
            ->method('expand')
            ->with($this->priceProductPriceListPageSearchTransferMock)
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $priceProductPriceListPageSearchTransfer = $this->priceProductAbstractSearchExpander
            ->expand($this->priceProductPriceListPageSearchTransferMock);

        $this->assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $priceProductPriceListPageSearchTransfer,
        );
    }
}
