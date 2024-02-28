<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Persister\CustomerProductListRelationPersister;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\CustomerProductListsBulkRestApiDependencyProvider;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence\CustomerProductListsBulkRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CustomerProductListsBulkRestApiBusinessFactoryTest extends Unit
{
    protected MockObject|CustomerProductListsBulkRestApiRepository $repositoryMock;

    protected Container|MockObject $containerMock;

    protected MockObject|CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $customerProductListConnectorFacadeMock;

    protected CustomerProductListsBulkRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CustomerProductListsBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerProductListConnectorFacadeMock = $this->getMockBuilder(CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CustomerProductListsBulkRestApiBusinessFactory();
        $this->factory->setRepository($this->repositoryMock);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateRestProductListsBulkRequestExpander(): void
    {
        static::assertInstanceOf(
            RestProductListsBulkRequestExpander::class,
            $this->factory->createRestProductListsBulkRequestExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCustomerProductListRelationPersister(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(CustomerProductListsBulkRestApiDependencyProvider::FACADE_CUSTOMER_PRODUCT_LIST_CONNECTOR)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CustomerProductListsBulkRestApiDependencyProvider::FACADE_CUSTOMER_PRODUCT_LIST_CONNECTOR)
            ->willReturn($this->customerProductListConnectorFacadeMock);

        static::assertInstanceOf(
            CustomerProductListRelationPersister::class,
            $this->factory->createCustomerProductListRelationPersister(),
        );
    }
}
