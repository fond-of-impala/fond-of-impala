<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListReaderTest extends Unit
{
    protected MockObject|CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $companyProductListConnectorFacadeMock;

    protected ProductListReader $productListReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyProductListConnectorFacadeMock = $this->getMockBuilder(CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListReader = new ProductListReader($this->companyProductListConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetIdsByIdCompany(): void
    {
        $idCustomer = 1;
        $productListIds = [1, 2, 4, 6];

        $this->companyProductListConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('getAssignedProductListIdsByIdCustomer')
            ->with($idCustomer)
            ->willReturn($productListIds);

        static::assertEquals(
            $productListIds,
            $this->productListReader->getIdsByIdCustomer($idCustomer),
        );
    }
}
