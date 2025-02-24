<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationNotifyQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use PHPUnit\Framework\MockObject\MockObject;

class NotifyCustomerQueryExpanderPluginTest extends Unit
{
    protected MockObject|FoiErpOrderCancellationQuery $foiErpOrderCancellationQueryMock;

    protected MockObject|FoiErpOrderCancellationNotifyQuery $foiErpOrderCancellationNotifyQueryMock;

    protected MockObject|ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    protected NotifyCustomerQueryExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->erpOrderCancellationFilterTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->foiErpOrderCancellationQueryMock = $this
            ->getMockBuilder(FoiErpOrderCancellationQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->foiErpOrderCancellationNotifyQueryMock = $this
            ->getMockBuilder(FoiErpOrderCancellationNotifyQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new NotifyCustomerQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $fkCustomer = 1;

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($fkCustomer);

        $isApplicable = $this->plugin->isApplicable($this->erpOrderCancellationFilterTransferMock);

        static::assertIsBool($isApplicable);

        static::assertTrue($isApplicable);
    }

    /**
     * @return void
     */
    public function testExpandErpOrderCancellationQuery(): void
    {
        $fkCustomer = 1;

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($fkCustomer);

        $this->foiErpOrderCancellationQueryMock->expects(static::atLeastOnce())
            ->method('joinFoiErpOrderCancellationNotify')
            ->willReturn($this->foiErpOrderCancellationQueryMock);

        $this->foiErpOrderCancellationQueryMock->expects(static::atLeastOnce())
            ->method('useFoiErpOrderCancellationNotifyQuery')
            ->willReturn($this->foiErpOrderCancellationNotifyQueryMock);

        $this->foiErpOrderCancellationNotifyQueryMock->expects(static::atLeastOnce())
            ->method('filterByFkCustomer')
            ->willReturn($this->foiErpOrderCancellationNotifyQueryMock);

        $this->foiErpOrderCancellationNotifyQueryMock->expects(static::atLeastOnce())
            ->method('endUse')
            ->willReturn($this->foiErpOrderCancellationQueryMock);

        static::assertEquals(
            $this->foiErpOrderCancellationQueryMock,
            $this->plugin->expandErpOrderCancellationQuery(
                $this->foiErpOrderCancellationQueryMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }
}
