<?php

namespace FondOfImpala\Zed\JellyfishSalesOrderPurchaser\Communication\Plugin\JellyfishSalesOrderExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\JellyfishOrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use PHPUnit\Framework\MockObject\MockObject;

class PurchaserJellyfishOrderExpanderPostMapPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\JellyfishOrderTransfer
     */
    protected MockObject|JellyfishOrderTransfer $jellyfishOrderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    protected MockObject|SpySalesOrder $salesOrderMock;

    /**
     * @var \FondOfImpala\Zed\JellyfishSalesOrderPurchaser\Communication\Plugin\JellyfishSalesOrderExtension\PurchaserJellyfishOrderExpanderPostMapPlugin
     */
    protected PurchaserJellyfishOrderExpanderPostMapPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->jellyfishOrderTransferMock = $this->getMockBuilder(JellyfishOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesOrderMock = $this->getMockBuilder(SpySalesOrder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new PurchaserJellyfishOrderExpanderPostMapPlugin();
    }

    /**
     * @return void
     */
    public function testSearchCompaniesAction(): void
    {
        $email = 'john.doe@example.com';

        $this->salesOrderMock->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn($email);

        $this->jellyfishOrderTransferMock->expects(static::atLeastOnce())
            ->method('setPurchaserEmail')
            ->with($email)
            ->willReturn($this->jellyfishOrderTransferMock);

        $jellyfishOrderTransfer = $this->plugin->expand($this->jellyfishOrderTransferMock, $this->salesOrderMock);

        static::assertEquals(
            $this->jellyfishOrderTransferMock,
            $jellyfishOrderTransfer,
        );
    }
}
