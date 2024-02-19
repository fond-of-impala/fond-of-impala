<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\BusinessCentralOrderBudgetsBulkRestApiFacade;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BusinessCentralRestOrderBudgetsBulkRequestExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension\PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\BusinessCentralOrderBudgetsBulkRestApiFacade
     */
    protected MockObject|BusinessCentralOrderBudgetsBulkRestApiFacadeInterface $facadeMock;

    /**
     * @var \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension\PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    /**
     * @var \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension\PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\OrderBudgetsBulkRestApiExtension\BusinessCentralRestOrderBudgetsBulkRequestExpanderPlugin
     */
    protected BusinessCentralRestOrderBudgetsBulkRequestExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(BusinessCentralOrderBudgetsBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new BusinessCentralRestOrderBudgetsBulkRequestExpanderPlugin();
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
