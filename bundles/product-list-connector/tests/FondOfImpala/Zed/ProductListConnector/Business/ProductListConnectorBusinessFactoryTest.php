<?php

namespace FondOfImpala\Zed\ProductListConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConnector\Business\Manager\ProductListManager;
use FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorEntityManager;
use FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorRepository;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorRepository
     */
    protected MockObject|ProductListConnectorRepository $productListConnectorRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorEntityManager
     */
    protected MockObject|ProductListConnectorEntityManager $productListConnectorEntityManagerMock;

    /**
     * @var \FondOfImpala\Zed\ProductListConnector\Business\ProductListConnectorBusinessFactory
     */
    protected ProductListConnectorBusinessFactory $productListConnectorBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListConnectorRepositoryMock = $this->getMockBuilder(ProductListConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConnectorEntityManagerMock = $this->getMockBuilder(ProductListConnectorEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConnectorBusinessFactory = new ProductListConnectorBusinessFactory();
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
