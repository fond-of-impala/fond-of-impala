<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageDataExpanderPluginInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductAbstractSearchExpanderTest extends Unit
{
    /**
     * @var array<\FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageDataExpanderPluginInterface>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $priceProductAbstractPriceListPageDataExpanderPluginMocks;

    protected MockObject|PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransferMock;

    protected PriceProductAbstractSearchExpander $priceProductAbstractSearchExpander;

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
        $this->priceProductAbstractPriceListPageDataExpanderPluginMocks[0]->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->priceProductPriceListPageSearchTransferMock)
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $priceProductPriceListPageSearchTransfer = $this->priceProductAbstractSearchExpander
            ->expand($this->priceProductPriceListPageSearchTransferMock);

        static::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $priceProductPriceListPageSearchTransfer,
        );
    }
}
