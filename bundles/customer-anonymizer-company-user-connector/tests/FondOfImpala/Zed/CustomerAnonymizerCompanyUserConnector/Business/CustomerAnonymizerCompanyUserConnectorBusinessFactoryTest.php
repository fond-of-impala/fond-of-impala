<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Deleter\CompanyUserDeleter;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorDependencyProvider;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CustomerAnonymizerCompanyUserConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Kernel\Container&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected Container|MockObject $containerMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorRepository|MockObject $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface|MockObject $eventFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorBusinessFactory
     */
    protected CustomerAnonymizerCompanyUserConnectorBusinessFactory $customerAnonymizerCompanyUserConnectorBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerAnonymizerCompanyUserConnectorBusinessFactory = new CustomerAnonymizerCompanyUserConnectorBusinessFactory();
        $this->customerAnonymizerCompanyUserConnectorBusinessFactory->setContainer($this->containerMock);
        $this->customerAnonymizerCompanyUserConnectorBusinessFactory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserDeleter(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CustomerAnonymizerCompanyUserConnectorDependencyProvider::FACADE_COMPANY_USER:
                        return $self->companyUserFacadeMock;
                    case CustomerAnonymizerCompanyUserConnectorDependencyProvider::FACADE_EVENT:
                        return $self->eventFacadeMock;
                }

                throw new Exception('Invalid key');
            });

        static::assertInstanceOf(
            CompanyUserDeleter::class,
            $this->customerAnonymizerCompanyUserConnectorBusinessFactory->createCompanyUserDeleter(),
        );
    }
}
