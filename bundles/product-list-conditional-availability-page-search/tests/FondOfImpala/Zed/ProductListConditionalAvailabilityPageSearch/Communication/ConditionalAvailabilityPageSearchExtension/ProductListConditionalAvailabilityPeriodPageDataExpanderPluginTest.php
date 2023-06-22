<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class ProductListConditionalAvailabilityPeriodPageDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension\ProductListConditionalAvailabilityPeriodPageDataExpanderPlugin
     */
    protected $productListPageDataExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade
     */
    protected $productListConditionalAvailabilityPageSearchFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected $conditionalAvailabilityPeriodPageSearchTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListConditionalAvailabilityPageSearchFacadeInterfaceMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPageDataExpanderPlugin = new class (
            $this->productListConditionalAvailabilityPageSearchFacadeInterfaceMock
        ) extends ProductListConditionalAvailabilityPeriodPageDataExpanderPlugin {
            /**
             * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade
             */
            protected $productListConditionalAvailabilityPageSearchFacade;

            /**
             * @param \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacade $productListConditionalAvailabilityPageSearchFacade
             */
            public function __construct(ProductListConditionalAvailabilityPageSearchFacade $productListConditionalAvailabilityPageSearchFacade)
            {
                $this->productListConditionalAvailabilityPageSearchFacade = $productListConditionalAvailabilityPageSearchFacade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->productListConditionalAvailabilityPageSearchFacade;
            }
        };
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->productListConditionalAvailabilityPageSearchFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('expandConditionalAvailabilityPeriodPageSearchTransferWithProductLists')
            ->with($this->conditionalAvailabilityPeriodPageSearchTransferMock)
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchTransferMock);

        $this->assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchTransfer::class,
            $this->productListPageDataExpanderPlugin->expand(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }
}
