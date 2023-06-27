<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListConditionalAvailabilityPageSearchFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade
     */
    protected ProductListConditionalAvailabilityPageSearchFacade $facade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchBusinessFactory
     */
    protected MockObject|ProductListConditionalAvailabilityPageSearchBusinessFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected MockObject|ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface
     */
    protected MockObject|ConditionalAvailabilityPeriodPageSearchExpanderInterface $conditionalAvailabilityPeriodPageSearchExpanderMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchExpanderMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ProductListConditionalAvailabilityPageSearchFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandConditionalAvailabilityPeriodPageSearchTransferWithProductLists(): void
    {
        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchExpander')
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchExpanderMock);

        $this->conditionalAvailabilityPeriodPageSearchExpanderMock->expects($this->atLeastOnce())
            ->method('expandWithProductLists')
            ->with($this->conditionalAvailabilityPeriodPageSearchTransferMock)
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            $this->facade->expandConditionalAvailabilityPeriodPageSearchTransferWithProductLists(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }
}
