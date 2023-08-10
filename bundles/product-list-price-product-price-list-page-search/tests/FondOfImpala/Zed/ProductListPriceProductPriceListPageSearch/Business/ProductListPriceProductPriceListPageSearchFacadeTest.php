<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductPriceListPageSearchExpanderInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class ProductListPriceProductPriceListPageSearchFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchBusinessFactory
     */
    protected $productListPriceProductPriceListPageSearchBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected $priceProductPriceListPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductPriceListPageSearchExpanderInterface
     */
    protected $priceProductAbstractPriceListPageSearchExpanderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductPriceListPageSearchExpanderInterface
     */
    protected $priceProductConcretePriceListPageSearchExpanderMock;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacade
     */
    protected $productListPriceProductPriceListPageSearchFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListPriceProductPriceListPageSearchBusinessFactoryMock = $this->getMockBuilder(ProductListPriceProductPriceListPageSearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchTransferMock = $this->getMockBuilder(PriceProductPriceListPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductAbstractPriceListPageSearchExpanderMock = $this->getMockBuilder(PriceProductPriceListPageSearchExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductConcretePriceListPageSearchExpanderMock = $this->getMockBuilder(PriceProductPriceListPageSearchExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductPriceListPageSearchFacade = new ProductListPriceProductPriceListPageSearchFacade();
        $this->productListPriceProductPriceListPageSearchFacade->setFactory($this->productListPriceProductPriceListPageSearchBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function expandPriceProductAbstractPriceListPageSearchWithProductLists(): void
    {
        $this->productListPriceProductPriceListPageSearchBusinessFactoryMock->expects(self::atLeastOnce())
            ->method('createPriceProductAbstractPriceListPageSearchExpander')
            ->willReturn($this->priceProductAbstractPriceListPageSearchExpanderMock);

        $this->priceProductAbstractPriceListPageSearchExpanderMock->expects(self::atLeastOnce())
            ->method('expandWithProductLists')
            ->with($this->priceProductPriceListPageSearchTransferMock)
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        self::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->productListPriceProductPriceListPageSearchFacade->expandPriceProductAbstractPriceListPageSearchWithProductLists(
                $this->priceProductPriceListPageSearchTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandPriceProductConcretePriceListPageSearchWithProductLists(): void
    {
        $this->productListPriceProductPriceListPageSearchBusinessFactoryMock->expects(self::atLeastOnce())
            ->method('createPriceProductConcretePriceListPageSearchExpander')
            ->willReturn($this->priceProductConcretePriceListPageSearchExpanderMock);

        $this->priceProductConcretePriceListPageSearchExpanderMock->expects(self::atLeastOnce())
            ->method('expandWithProductLists')
            ->with($this->priceProductPriceListPageSearchTransferMock)
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        self::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->productListPriceProductPriceListPageSearchFacade->expandPriceProductConcretePriceListPageSearchWithProductLists(
                $this->priceProductPriceListPageSearchTransferMock,
            ),
        );
    }
}
