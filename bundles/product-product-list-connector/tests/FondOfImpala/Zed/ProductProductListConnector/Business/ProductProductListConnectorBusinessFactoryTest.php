<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductProductListConnector\Business\Manager\ProductListManager;
use FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorEntityManager;
use FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorRepository;
use PHPUnit\Framework\MockObject\MockObject;

class ProductProductListConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorRepository
     */
    protected MockObject|ProductProductListConnectorRepository $productListConnectorRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorEntityManager
     */
    protected MockObject|ProductProductListConnectorEntityManager $productListConnectorEntityManagerMock;

    /**
     * @var \FondOfImpala\Zed\ProductProductListConnector\Business\ProductProductListConnectorBusinessFactory
     */
    protected ProductProductListConnectorBusinessFactory $productListConnectorBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListConnectorRepositoryMock = $this->getMockBuilder(ProductProductListConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConnectorEntityManagerMock = $this->getMockBuilder(ProductProductListConnectorEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConnectorBusinessFactory = new ProductProductListConnectorBusinessFactory();
        $this->productListConnectorBusinessFactory->setRepository($this->productListConnectorRepositoryMock);
        $this->productListConnectorBusinessFactory->setEntityManager($this->productListConnectorEntityManagerMock);
    }

    /**
     * @return void
     */
    public function testCreateProductListManager(): void
    {
        static::assertInstanceOf(
            ProductListManager::class,
            $this->productListConnectorBusinessFactory->createProductListManager(),
        );
    }
}
