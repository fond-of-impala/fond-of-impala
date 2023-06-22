<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;

class ProductListConditionalAvailabilityPageSearchFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade
     */
    protected $productListConditionalAvailabilityPageSearchFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchBusinessFactory
     */
    protected $productListConditionalAvailabilityPageSearchBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected $conditionalAvailabilityPeriodPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityPeriodPageSearchExpanderInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListConditionalAvailabilityPageSearchBusinessFactoryMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchExpanderInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchFacade = new ProductListConditionalAvailabilityPageSearchFacade();
        $this->productListConditionalAvailabilityPageSearchFacade->setFactory($this->productListConditionalAvailabilityPageSearchBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandConditionalAvailabilityPeriodPageSearchTransferWithProductLists(): void
    {
        $this->productListConditionalAvailabilityPageSearchBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchExpander')
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchExpanderInterfaceMock);

        $this->conditionalAvailabilityPeriodPageSearchExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('expandWithProductLists')
            ->with($this->conditionalAvailabilityPeriodPageSearchTransferMock)
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchTransferMock);

        $this->assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchTransfer::class,
            $this->productListConditionalAvailabilityPageSearchFacade->expandConditionalAvailabilityPeriodPageSearchTransferWithProductLists(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }
}
