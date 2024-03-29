<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class ProductListConditionalAvailabilityPeriodPageDataExpanderPluginTest extends Unit
{
    protected ProductListConditionalAvailabilityPeriodPageDataExpanderPlugin $plugin;

    protected MockObject|ProductListConditionalAvailabilityPageSearchFacade $facadeMock;

    protected MockObject|ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new class (
            $this->facadeMock
        ) extends ProductListConditionalAvailabilityPeriodPageDataExpanderPlugin {
            protected ProductListConditionalAvailabilityPageSearchFacade $productListConditionalAvailabilityPageSearchFacade;

            /**
             * @param \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade $productListConditionalAvailabilityPageSearchFacade
             */
            public function __construct(ProductListConditionalAvailabilityPageSearchFacade $productListConditionalAvailabilityPageSearchFacade)
            {
                $this->facade = $productListConditionalAvailabilityPageSearchFacade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->facade;
            }
        };
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandConditionalAvailabilityPeriodPageSearchTransferWithProductLists')
            ->with($this->conditionalAvailabilityPeriodPageSearchTransferMock)
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            $this->plugin->expand(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }
}
