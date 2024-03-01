<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListReaderTest extends Unit
{
    protected MockObject|CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacadeMock;

    protected ProductListReader $productListReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyProductListConnectorFacadeMock = $this->getMockBuilder(CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListReader = new ProductListReader($this->companyProductListConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetIdsByIdCompany(): void
    {
        $idCompany = 1;
        $productListIds = [1, 2, 4, 6];

        $this->companyProductListConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('getAssignedProductListIdsByIdCompany')
            ->with($idCompany)
            ->willReturn($productListIds);

        static::assertEquals(
            $productListIds,
            $this->productListReader->getIdsByIdCompany($idCompany),
        );
    }
}
