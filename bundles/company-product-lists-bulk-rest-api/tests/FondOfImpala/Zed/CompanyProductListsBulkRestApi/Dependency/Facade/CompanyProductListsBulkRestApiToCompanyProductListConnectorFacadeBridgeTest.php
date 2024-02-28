<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfOryx\Zed\CompanyProductListConnector\Business\CompanyProductListConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyProductListRelationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeBridgeTest extends Unit
{
    protected CompanyProductListConnectorFacadeInterface|MockObject $facadeMock;

    protected CompanyProductListRelationTransfer|MockObject $companyProductListRelationTransferMock;

    protected CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CompanyProductListConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyProductListRelationTransferMock = $this->getMockBuilder(CompanyProductListRelationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testPersistCompanyProductListRelation(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('persistCompanyProductListRelation')
            ->with($this->companyProductListRelationTransferMock);

        $this->bridge->persistCompanyProductListRelation($this->companyProductListRelationTransferMock);
    }

    /**
     * @return void
     */
    public function testGetAssignedProductListIdsByIdCompany(): void
    {
        $idCompany = 1;
        $productListIds = [1, 2, 3];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getAssignedProductListIdsByIdCompany')
            ->with($idCompany)
            ->willReturn($productListIds);

        static::assertEquals(
            $productListIds,
            $this->bridge->getAssignedProductListIdsByIdCompany($idCompany),
        );
    }
}
