<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListConditionalAvailabilityPageSearchFacadeTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchFacade $facade;

    protected MockObject|ProductListConditionalAvailabilityPageSearchBusinessFactory $factoryMock;

    protected MockObject|ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransferMock;

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
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchExpander')
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchExpanderMock);

        $this->conditionalAvailabilityPeriodPageSearchExpanderMock->expects(static::atLeastOnce())
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
