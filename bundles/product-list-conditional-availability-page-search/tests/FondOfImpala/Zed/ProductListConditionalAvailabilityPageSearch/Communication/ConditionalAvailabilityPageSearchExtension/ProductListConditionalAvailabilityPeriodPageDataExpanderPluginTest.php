<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class ProductListConditionalAvailabilityPeriodPageDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension\ProductListConditionalAvailabilityPeriodPageDataExpanderPlugin
     */
    protected ProductListConditionalAvailabilityPeriodPageDataExpanderPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade
     */
    protected MockObject|ProductListConditionalAvailabilityPageSearchFacade $facadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
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
            /**
             * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade
             */
            protected $facade;

            /**
             * @param \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade $productListConditionalAvailabilityPageSearchFacade
             */
            public function __construct(ProductListConditionalAvailabilityPageSearchFacade $facade)
            {
                $this->facade = $facade;
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
        $this->facadeMock->expects($this->atLeastOnce())
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
