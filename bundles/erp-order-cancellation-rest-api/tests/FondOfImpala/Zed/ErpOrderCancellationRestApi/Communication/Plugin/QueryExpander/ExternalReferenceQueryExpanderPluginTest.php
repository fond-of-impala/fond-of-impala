<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use PHPUnit\Framework\MockObject\MockObject;

class ExternalReferenceQueryExpanderPluginTest extends Unit
{
    protected MockObject|FoiErpOrderCancellationQuery $foiErpOrderCancellationQueryMock;

    protected MockObject|ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    protected ExternalReferenceQueryExpanderPlugin $plugin;

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

        $this->plugin = new ExternalReferenceQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $externalReferences = ['externalReference'];

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getExternalReferences')
            ->willReturn($externalReferences);

        $isApplicable = $this->plugin->isApplicable($this->erpOrderCancellationFilterTransferMock);

        static::assertIsBool($isApplicable);

        static::assertTrue($isApplicable);
    }

    /**
     * @return void
     */
    public function testExpandErpOrderCancellationQuery(): void
    {
        $externalReferences = ['externalReference'];

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getExternalReferences')
            ->willReturn($externalReferences);

        $this->foiErpOrderCancellationQueryMock->expects(static::atLeastOnce())
            ->method('filterByErpOrderExternalReference_In')
            ->willReturn($externalReferences)
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
