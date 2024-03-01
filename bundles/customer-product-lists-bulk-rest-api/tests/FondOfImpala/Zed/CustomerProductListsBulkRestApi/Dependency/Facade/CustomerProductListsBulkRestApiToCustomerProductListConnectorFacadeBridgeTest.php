<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfOryx\Zed\CustomerProductListConnector\Business\CustomerProductListConnectorFacadeInterface;
use Generated\Shared\Transfer\CustomerProductListRelationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeBridgeTest extends Unit
{
    protected CustomerProductListConnectorFacadeInterface|MockObject $facadeMock;

    protected CustomerProductListRelationTransfer|MockObject $companyProductListRelationTransferMock;

    protected CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CustomerProductListConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyProductListRelationTransferMock = $this->getMockBuilder(CustomerProductListRelationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testPersistCustomerProductListRelation(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('persistCustomerProductListRelation')
            ->with($this->companyProductListRelationTransferMock);

        $this->bridge->persistCustomerProductListRelation($this->companyProductListRelationTransferMock);
    }

    /**
     * @return void
     */
    public function testGetAssignedProductListIdsByIdCustomer(): void
    {
        $idCustomer = 1;
        $productListIds = [1, 2, 3];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getAssignedProductListIdsByIdCustomer')
            ->with($idCustomer)
            ->willReturn($productListIds);

        static::assertEquals(
            $productListIds,
            $this->bridge->getAssignedProductListIdsByIdCustomer($idCustomer),
        );
    }
}
