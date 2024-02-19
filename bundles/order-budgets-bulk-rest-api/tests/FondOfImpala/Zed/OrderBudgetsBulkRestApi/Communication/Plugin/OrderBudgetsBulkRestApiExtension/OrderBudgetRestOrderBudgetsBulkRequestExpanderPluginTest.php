<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\OrderBudgetsBulkRestApiFacade;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetRestOrderBudgetsBulkRequestExpanderPluginTest extends Unit
{
    protected MockObject|OrderBudgetsBulkRestApiFacade $facadeMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    protected OrderBudgetRestOrderBudgetsBulkRequestExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(OrderBudgetsBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OrderBudgetRestOrderBudgetsBulkRequestExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandRestOrderBudgetsBulkRequest')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $this->plugin->expand($this->restOrderBudgetsBulkRequestTransferMock),
        );
    }
}
