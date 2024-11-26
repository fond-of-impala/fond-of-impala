<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\ProductListIdsFilterInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use Generated\Shared\Transfer\CompanyProductListRelationTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCompanyTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyProductListRelationMapperTest extends Unit
{
    protected ProductListIdsFilterInterface|MockObject $productListIdsFilterMock;

    protected ProductListReaderInterface|MockObject $productListReaderMock;

    protected RestProductListsBulkRequestAssignmentTransfer|MockObject $restProductListsBulkRequestAssignmentTransferMock;

    protected CompanyProductListRelationTransfer|MockObject $companyProductListRelationTransferMock;

    protected RestProductListsBulkRequestAssignmentCompanyTransfer|MockObject $restProductListsBulkRequestAssignmentCompanyTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentProductListTransferMocks;

    protected CompanyProductListRelationMapper $companyProductListRelationMapper;

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

        $this->companyProductListRelationTransferMock = $this->getMockBuilder(CompanyProductListRelationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentCompanyTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentCompanyTransfer::class)
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

        $this->companyProductListRelationMapper = new CompanyProductListRelationMapper(
            $this->productListIdsFilterMock,
            $this->productListReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkRequestAssignmentTransfer(): void
    {
        $idCompany = 1;
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
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMock);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($idCompany);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssignMocks);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassignMocks);

        $this->productListIdsFilterMock->expects($this->atLeastOnce())
            ->method('filterFromRestProductListsBulkRequestAssignmentProductLists')
            ->willReturnCallback(static function (ArrayObject $productLists) use ($productListsToAssignMocks, $productListsToUnassignMocks, $productListIdsToAssign, $productListIdsToUnassign) {
                if ($productLists === $productListsToAssignMocks) {
                    return $productListIdsToAssign;
                }

                if ($productLists === $productListsToUnassignMocks) {
                    return $productListIdsToUnassign;
                }

                throw new Exception('Unexpected call');
            });

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getIdsByIdCompany')
            ->with($idCompany)
            ->willReturn($productListIds);

        $companyProductListRelationTransfer = $this->companyProductListRelationMapper->fromRestProductListsBulkRequestAssignmentTransfer(
            $this->restProductListsBulkRequestAssignmentTransferMock,
        );

        static::assertEquals(
            $idCompany,
            $companyProductListRelationTransfer->getIdCompany(),
        );

        static::assertEquals(
            [2, 5, 6, 8],
            $companyProductListRelationTransfer->getProductListIds(),
        );
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkRequestAssignmentTransferWithoutCompany(): void
    {
        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::never())
            ->method('getProductListsToAssign');

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::never())
            ->method('getProductListsToUnassign');

        $this->productListIdsFilterMock->expects(static::never())
            ->method('filterFromRestProductListsBulkRequestAssignmentProductLists');

        $this->productListReaderMock->expects(static::never())
            ->method('getIdsByIdCompany');

        static::assertEquals(
            null,
            $this->companyProductListRelationMapper->fromRestProductListsBulkRequestAssignmentTransfer(
                $this->restProductListsBulkRequestAssignmentTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFromRestProductListsBulkRequestAssignmentTransferWithoutCompanyId(): void
    {
        $idCompany = null;
        $productListIdsToAssign = [8];
        $productListIdsToUnassign = [1];

        $productListsToAssignMocks = new ArrayObject([
            $this->restProductListsBulkRequestAssignmentProductListTransferMocks[0],
        ]);

        $productListsToUnassignMocks = new ArrayObject([
            $this->restProductListsBulkRequestAssignmentProductListTransferMocks[1],
        ]);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restProductListsBulkRequestAssignmentCompanyTransferMock);

        $this->restProductListsBulkRequestAssignmentCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($idCompany);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToAssign')
            ->willReturn($productListsToAssignMocks);

        $this->restProductListsBulkRequestAssignmentTransferMock->expects(static::atLeastOnce())
            ->method('getProductListsToUnassign')
            ->willReturn($productListsToUnassignMocks);

        $this->productListIdsFilterMock->expects($this->atLeastOnce())
            ->method('filterFromRestProductListsBulkRequestAssignmentProductLists')
            ->willReturnCallback(static function (ArrayObject $productLists) use ($productListsToAssignMocks, $productListsToUnassignMocks, $productListIdsToAssign, $productListIdsToUnassign) {
                if ($productLists === $productListsToAssignMocks) {
                    return $productListIdsToAssign;
                }

                if ($productLists === $productListsToUnassignMocks) {
                    return $productListIdsToUnassign;
                }

                throw new Exception('Unexpected call');
            });

        $this->productListReaderMock->expects(static::never())
            ->method('getIdsByIdCompany');

        static::assertEquals(
            null,
            $this->companyProductListRelationMapper->fromRestProductListsBulkRequestAssignmentTransfer(
                $this->restProductListsBulkRequestAssignmentTransferMock,
            ),
        );
    }
}
