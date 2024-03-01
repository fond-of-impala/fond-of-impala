<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Persister\CompanyProductListRelationPersister;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\CompanyProductListsBulkRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence\CompanyProductListsBulkRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CompanyProductListsBulkRestApiBusinessFactoryTest extends Unit
{
    protected MockObject|CompanyProductListsBulkRestApiRepository $repositoryMock;

    protected Container|MockObject $containerMock;

    protected MockObject|CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacadeMock;

    protected CompanyProductListsBulkRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyProductListsBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyProductListConnectorFacadeMock = $this->getMockBuilder(CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyProductListsBulkRestApiBusinessFactory();
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
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
    public function testCreateCompanyProductListRelationPersister(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(CompanyProductListsBulkRestApiDependencyProvider::FACADE_COMPANY_PRODUCT_LIST_CONNECTOR)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyProductListsBulkRestApiDependencyProvider::FACADE_COMPANY_PRODUCT_LIST_CONNECTOR)
            ->willReturn($this->companyProductListConnectorFacadeMock);

        static::assertInstanceOf(
            CompanyProductListRelationPersister::class,
            $this->factory->createCompanyProductListRelationPersister(),
        );
    }
}
