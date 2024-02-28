<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer;

class ProductListIdsFilterTest extends Unit
{
    /**
     * @var array<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $restProductListsBulkRequestAssignmentProductListTransferMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestAssignmentProductListTransferMocks = [
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentProductListTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestProductListsBulkRequestAssignmentProductListTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->productListIdsFilter = new ProductListIdsFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromRestProductListsBulkRequestAssignmentProductLists(): void
    {
        $productListId = 2;

        $this->restProductListsBulkRequestAssignmentProductListTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($productListId);

        $this->restProductListsBulkRequestAssignmentProductListTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        static::assertEquals(
            [2],
            $this->productListIdsFilter->filterFromRestProductListsBulkRequestAssignmentProductLists(
                new ArrayObject($this->restProductListsBulkRequestAssignmentProductListTransferMocks),
            ),
        );
    }
}
