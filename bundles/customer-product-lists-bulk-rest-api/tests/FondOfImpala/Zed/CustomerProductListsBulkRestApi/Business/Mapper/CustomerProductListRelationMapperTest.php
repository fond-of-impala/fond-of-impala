<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\ProductListIdsFilterInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use Generated\Shared\Transfer\CustomerProductListRelationTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCustomerTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerProductListRelationMapperTest extends Unit
{
    protected ProductListIdsFilterInterface|MockObject $productListIdsFilterMock;

    protected ProductListReaderInterface|MockObject $productListReaderMock;

    protected RestProductListsBulkRequestAssignmentTransfer|MockObject $restProductListsBulkRequestAssignmentTransferMock;

    protected CustomerProductListRelationTransfer|MockObject $customerProductListRelationTransferMock;

    protected RestProductListsBulkRequestAssignmentCustomerTransfer|MockObject $restProductListsBulkRequestAssignmentCustomerTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentProductListTransferMocks;

    protected CustomerProductListRelationMapper $customerProductListRelationMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productListIdsFilterMock = $this->getMockBuilder(ProductListIdsFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListReaderMock = $this->getMockBuilder(ProductListReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerProductListRelationTransferMock = $this->getMockBuilder(CustomerProductListRelationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentCustomerTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentProductListTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentProductListTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentProductListTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->customerProductListRelationMapper = new CustomerProductListRelationMapper(
            $this->productListIdsFilterMock,
            $this->productListReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkRequestAssignmentTransfer(): void
    {
        $idCustomer = 1;
        $productListIdsToAssign = [8];
        $productListIdsToUnassign = [1];
        $productListIds = [1, 2, 5, 6];

        $productListsToAssignMocks = new ArrayObject([
            $this->restProductListsBulkRequestAssignmentProductListTransferMocks[0],
        ]);

        $productListsToUnassignMocks = new ArrayObject([
            $this->restProductListsBulkRequestAssignmentProductListTransferMocks[1],
        ]);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMock);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($idCustomer);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssignMocks);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassignMocks);

        $this->productListIdsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestProductListsBulkRequestAssignmentProductLists')
            ->withConsecutive(
                [$productListsToAssignMocks],
                [$productListsToUnassignMocks],
            )->willReturnOnConsecutiveCalls(
                $productListIdsToAssign,
                $productListIdsToUnassign,
            );

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByIdCustomer')
            ->with($idCustomer)
            ->willReturn($productListIds);

        $customerProductListRelationTransfer = $this->customerProductListRelationMapper->fromRestProductListsBulkRequestAssignmentTransfer(
            $this->restProductListsBulkRequestAssignmentTransferMock,
        );

        static::assertEquals(
            $idCustomer,
            $customerProductListRelationTransfer->getIdCustomer(),
        );

        static::assertEquals(
            [2, 5, 6, 8],
            $customerProductListRelationTransfer->getProductListIds(),
        );
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkRequestAssignmentTransferWithoutCustomer(): void
    {
        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::never())
            ->method('getProductListsToAssign');

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::never())
            ->method('getProductListsToUnassign');

        $this->productListIdsFilterMock->expects(static::never())
            ->method('filterFromRestProductListsBulkRequestAssignmentProductLists');

        $this->productListReaderMock->expects(static::never())
            ->method('getIdsByIdCustomer');

        static::assertEquals(
            null,
            $this->customerProductListRelationMapper->fromRestProductListsBulkRequestAssignmentTransfer(
                $this->restProductListsBulkRequestAssignmentTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkRequestAssignmentTransferWithoutCustomerId(): void
    {
        $idCustomer = null;
        $productListIdsToAssign = [8];
        $productListIdsToUnassign = [1];

        $productListsToAssignMocks = new ArrayObject([
            $this->restProductListsBulkRequestAssignmentProductListTransferMocks[0],
        ]);

        $productListsToUnassignMocks = new ArrayObject([
            $this->restProductListsBulkRequestAssignmentProductListTransferMocks[1],
        ]);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restProductListsBulkRequestAssignmentCustomerTransferMock);

        $this->restProductListsBulkRequestAssignmentCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($idCustomer);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssignMocks);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassignMocks);

        $this->productListIdsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestProductListsBulkRequestAssignmentProductLists')
            ->withConsecutive(
                [$productListsToAssignMocks],
                [$productListsToUnassignMocks],
            )->willReturnOnConsecutiveCalls(
                $productListIdsToAssign,
                $productListIdsToUnassign,
            );

        $this->productListReaderMock->expects(static::never())
            ->method('getIdsByIdCustomer');

        static::assertEquals(
            null,
            $this->customerProductListRelationMapper->fromRestProductListsBulkRequestAssignmentTransfer(
                $this->restProductListsBulkRequestAssignmentTransferMock,
            ),
        );
    }
}
