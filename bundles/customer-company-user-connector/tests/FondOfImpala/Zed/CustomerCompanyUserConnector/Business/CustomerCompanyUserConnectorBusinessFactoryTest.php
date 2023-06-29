<?php

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model\CompanyUserDeleter;
use FondOfImpala\Zed\CustomerCompanyUserConnector\CustomerCompanyUserConnectorDependencyProvider;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence\CustomerCompanyUserConnectorRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CustomerCompanyUserConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Kernel\Container&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected Container|MockObject $containerMock;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence\CustomerCompanyUserConnectorRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerCompanyUserConnectorRepository|MockObject $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerCompanyUserConnectorToCompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Business\CustomerCompanyUserConnectorBusinessFactory
     */
    protected CustomerCompanyUserConnectorBusinessFactory $customerCompanyUserConnectorBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CustomerCompanyUserConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CustomerCompanyUserConnectorToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerCompanyUserConnectorBusinessFactory = new CustomerCompanyUserConnectorBusinessFactory();
        $this->customerCompanyUserConnectorBusinessFactory->setContainer($this->containerMock);
        $this->customerCompanyUserConnectorBusinessFactory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserDeleter(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CustomerCompanyUserConnectorDependencyProvider::FACADE_COMPANY_USER],
            )->willReturnOnConsecutiveCalls(
                $this->companyUserFacadeMock,
            );

        static::assertInstanceOf(
            CompanyUserDeleter::class,
            $this->customerCompanyUserConnectorBusinessFactory->createCompanyUserDeleter(),
        );
    }
}
