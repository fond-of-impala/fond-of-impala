<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use PHPUnit\Framework\MockObject\MockObject;

class ReferenceQueryExpanderPluginTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander\ReferenceQueryExpanderPlugin
     */
    protected ReferenceQueryExpanderPlugin $plugin;

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

        $this->plugin = new ReferenceQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $references = ['reference'];

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getReferences')
            ->willReturn($references);

        $isApplicable = $this->plugin->isApplicable($this->erpOrderCancellationFilterTransferMock);

        static::assertIsBool($isApplicable);

        static::assertTrue($isApplicable);
    }

    /**
     * @return void
     */
    public function testExpandErpOrderCancellationQuery(): void
    {
        $references = ['reference'];

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getReferences')
            ->willReturn($references);

        $this->foiErpOrderCancellationQueryMock->expects(static::atLeastOnce())
            ->method('filterByErpOrderReference_In')
            ->willReturn($references)
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
