<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use PHPUnit\Framework\MockObject\MockObject;

class StatesQueryExpanderPluginTest extends Unit
{
    protected MockObject|FoiErpOrderCancellationQuery $foiErpOrderCancellationQueryMock;

    protected MockObject|ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    protected StatesQueryExpanderPlugin $plugin;

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

        $this->plugin = new StatesQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getStates')
            ->willReturn(['state1', 'state2']);

        $isApplicable = $this->plugin->isApplicable($this->erpOrderCancellationFilterTransferMock);

        static::assertIsBool($isApplicable);

        static::assertTrue($isApplicable);
    }

    /**
     * @return void
     */
    public function testExpandErpOrderCancellationQuery(): void
    {
        $states = ['state1', 'state2'];

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getStates')
            ->willReturn($states);

        $this->foiErpOrderCancellationQueryMock->expects(static::atLeastOnce())
            ->method('filterByState_In')
            ->willReturn($states)
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
