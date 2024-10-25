<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use PHPUnit\Framework\MockObject\MockObject;

class DebitorNumberQueryExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    protected MockObject|FoiErpOrderCancellationQuery $foiErpOrderCancellationQuery;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer
     */
    protected MockObject|RestErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander\DebitorNumberQueryExpanderPlugin
     */
    protected DebitorNumberQueryExpanderPlugin $plugin;

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
            ->getMockBuilder( FoiErpOrderCancellationQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new DebitorNumberQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $debtorNumber = ['debitorNumber'];

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumbers')
            ->willReturn($debtorNumber);

        $isApplicable =$this->plugin->isApplicable($this->erpOrderCancellationFilterTransferMock);

        static::assertIsBool($isApplicable);

        static::assertTrue($isApplicable);
    }

    /**
     * @return void
     */
    public function testExpandErpOrderCancellationQuery(): void
    {
        $debtorNumber = ['debitorNumber'];

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumbers')
            ->willReturn($debtorNumber);

        $this->foiErpOrderCancellationQueryMock->expects(static::atLeastOnce())
            ->method('filterByDebitorNumber_In')
            ->willReturn($debtorNumber)
            ->willReturn($this->foiErpOrderCancellationQueryMock);

        static::assertEquals(
            $this->foiErpOrderCancellationQueryMock,
            $this->plugin->expandErpOrderCancellationQuery(
                $this->foiErpOrderCancellationQueryMock,
                $this->erpOrderCancellationFilterTransferMock
            ),
        );
    }
}
