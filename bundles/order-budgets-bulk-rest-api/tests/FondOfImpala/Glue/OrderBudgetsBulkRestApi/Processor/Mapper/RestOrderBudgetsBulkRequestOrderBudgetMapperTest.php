<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestOrderBudgetsBulkRequestOrderBudgetMapperTest extends Unit
{
    protected RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface|MockObject $restOrderBudgetsBulkRequestOrderBudgetMapperPluginMock;

    protected MockObject|RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransferMock;

    protected RestOrderBudgetsBulkRequestOrderBudgetTransfer|MockObject $restOrderBudgetsBulkRequestOrderBudgetTransferMock;

    protected RestOrderBudgetsBulkRequestOrderBudgetMapper $restOrderBudgetsBulkRequestOrderBudgetMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restOrderBudgetsBulkRequestOrderBudgetMapperPluginMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkOrderBudgetTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestOrderBudgetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestOrderBudgetMapper = new RestOrderBudgetsBulkRequestOrderBudgetMapper(
            [$this->restOrderBudgetsBulkRequestOrderBudgetMapperPluginMock],
        );
    }

    /**
     * @return void
     */
    public function testFromRestOrderBudgetsBulkOrderBudget(): void
    {
        $uuid = 'bccfc30e-550d-4367-902f-7b7f5bbe8520';
        $nextInitialBudget = 100000;

        $this->restOrderBudgetsBulkOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($uuid);

        $this->restOrderBudgetsBulkOrderBudgetTransferMock->expects(static::atLeastOnce())
            ->method('getNextInitialBudget')
            ->willReturn($nextInitialBudget);

        $this->restOrderBudgetsBulkRequestOrderBudgetMapperPluginMock->expects(static::atLeastOnce())
            ->method('mapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudget')
            ->with(
                $this->restOrderBudgetsBulkOrderBudgetTransferMock,
                static::callback(
                    static fn (RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer): bool => $restOrderBudgetsBulkRequestOrderBudgetTransfer->getUuid() === $uuid
                        && $restOrderBudgetsBulkRequestOrderBudgetTransfer->getNextInitialBudget() === $nextInitialBudget,
                ),
            )->willReturn($this->restOrderBudgetsBulkRequestOrderBudgetTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestOrderBudgetTransferMock,
            $this->restOrderBudgetsBulkRequestOrderBudgetMapper->fromRestOrderBudgetsBulkOrderBudget(
                $this->restOrderBudgetsBulkOrderBudgetTransferMock,
            ),
        );
    }
}
