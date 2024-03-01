<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentProductListTransfer;

class RestProductListsBulkRequestAssignmentProductListsMapperTest extends Unit
{
    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkAssignmentProductListTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkAssignmentProductListTransferMocks;

    protected RestProductListsBulkRequestAssignmentProductListsMapper $restProductListsBulkRequestAssignmentProductListsMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkAssignmentProductListTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkAssignmentProductListTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkAssignmentProductListTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restProductListsBulkRequestAssignmentProductListsMapper = new RestProductListsBulkRequestAssignmentProductListsMapper();
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkAssignmentProductLists(): void
    {
        $key = 'foo';

        $this->restProductListsBulkAssignmentProductListTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restProductListsBulkAssignmentProductListTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn(null);

        $this->restProductListsBulkAssignmentProductListTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restProductListsBulkAssignmentProductListTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn($key);

        $restProductListsBulkRequestAssignmentProductListTransfers = $this->restProductListsBulkRequestAssignmentProductListsMapper
            ->fromRestProductListsBulkAssignmentProductLists(
                new ArrayObject($this->restProductListsBulkAssignmentProductListTransferMocks),
            );

        static::assertCount(1, $restProductListsBulkRequestAssignmentProductListTransfers);
        static::assertEquals($key, $restProductListsBulkRequestAssignmentProductListTransfers[0]->getKey());
    }
}
