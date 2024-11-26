<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentProductListTransfer;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestProductListsBulkRequestAssignmentMapperTest extends Unit
{
    protected RestProductListsBulkRequestAssignmentProductListsMapperInterface|MockObject $restProductListsBulkRequestAssignmentProductListsMapperMock;

    protected RestProductListsBulkRequestAssignmentMapperPluginInterface|MockObject $restProductListsBulkRequestAssignmentMapperPluginMock;

    protected MockObject|RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkAssignmentProductListTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkAssignmentProductListTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentProductListTransferMocks;

    protected RestProductListsBulkRequestAssignmentTransfer|MockObject $restProductListsBulkRequestAssignmentTransferMock;

    protected RestProductListsBulkRequestAssignmentMapper $restProductListsBulkRequestAssignmentMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestAssignmentProductListsMapperMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentProductListsMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentMapperPluginMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentMapperPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkAssignmentProductListTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkAssignmentProductListTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restProductListsBulkRequestAssignmentProductListTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentProductListTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restProductListsBulkRequestAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentMapper = new RestProductListsBulkRequestAssignmentMapper(
            $this->restProductListsBulkRequestAssignmentProductListsMapperMock,
            [$this->restProductListsBulkRequestAssignmentMapperPluginMock],
        );
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkAssignment(): void
    {
        $self = $this;

        $restProductListsBulkAssignmentProductListToUnassignTransferMock = new ArrayObject();
        $restProductListsBulkAssignmentProductListToAssignTransferMock = new ArrayObject(
            $this->restProductListsBulkAssignmentProductListTransferMocks,
        );

        $restProductListsBulkRequestAssignmentProductListToUnassignTransferMock = new ArrayObject();
        $restProductListsBulkRequestAssignmentProductListToAssignTransferMock = new ArrayObject(
            $this->restProductListsBulkRequestAssignmentProductListTransferMocks,
        );

        $this->restProductListsBulkAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($restProductListsBulkAssignmentProductListToAssignTransferMock);

        $this->restProductListsBulkAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($restProductListsBulkAssignmentProductListToUnassignTransferMock);

        $callCount = $this->atLeastOnce();
        $this->restProductListsBulkRequestAssignmentProductListsMapperMock->expects($callCount)
            ->method('fromRestProductListsBulkAssignmentProductLists')
            ->willReturnCallback(static function (ArrayObject $arrayObject) use ($self, $callCount, $restProductListsBulkAssignmentProductListToAssignTransferMock, $restProductListsBulkAssignmentProductListToUnassignTransferMock, $restProductListsBulkRequestAssignmentProductListToAssignTransferMock, $restProductListsBulkRequestAssignmentProductListToUnassignTransferMock) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame($arrayObject, $restProductListsBulkAssignmentProductListToAssignTransferMock);

                        return $restProductListsBulkRequestAssignmentProductListToAssignTransferMock;
                    case 2:
                        $self->assertSame($arrayObject, $restProductListsBulkAssignmentProductListToUnassignTransferMock);

                        return $restProductListsBulkRequestAssignmentProductListToUnassignTransferMock;
                }

                throw new Exception('Unexpected call count');
            });

        $this->restProductListsBulkRequestAssignmentMapperPluginMock->expects(static::atLeastOnce())
            ->method('mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment')
            ->with(
                $this->restProductListsBulkAssignmentTransferMock,
                static::callback(
                    static fn (RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer): bool => $restProductListsBulkRequestAssignmentTransfer->getProductListsToAssign() === $restProductListsBulkRequestAssignmentProductListToAssignTransferMock
                        && $restProductListsBulkRequestAssignmentTransfer->getProductListsToUnassign() === $restProductListsBulkRequestAssignmentProductListToUnassignTransferMock,
                ),
            )->willReturn($this->restProductListsBulkRequestAssignmentTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestAssignmentTransferMock,
            $this->restProductListsBulkRequestAssignmentMapper->fromRestProductListsBulkAssignment(
                $this->restProductListsBulkAssignmentTransferMock,
            ),
        );
    }
}
