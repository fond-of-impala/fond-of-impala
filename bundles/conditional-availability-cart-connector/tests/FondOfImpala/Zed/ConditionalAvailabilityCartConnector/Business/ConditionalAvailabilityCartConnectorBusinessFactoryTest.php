<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepository;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityCartConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorBusinessFactory
     */
    protected $conditionalAvailabilityCartConnectorBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected $conditionalAvailabilityServiceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepository
     */
    protected $conditionalAvailabilityCartConnectorRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
     */
    protected $customerFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    protected $conditionalAvailabilityCartConnectorServiceInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorRepositoryMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorServiceInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorBusinessFactory = new ConditionalAvailabilityCartConnectorBusinessFactory();
        $this->conditionalAvailabilityCartConnectorBusinessFactory->setContainer($this->containerMock);
        $this->conditionalAvailabilityCartConnectorBusinessFactory->setRepository($this->conditionalAvailabilityCartConnectorRepositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityExpander(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityCartConnectorDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityCartConnectorDependencyProvider::FACADE_CUSTOMER],
            )
            ->willReturnOnConsecutiveCalls(
                $this->conditionalAvailabilityFacadeInterfaceMock,
                $this->conditionalAvailabilityServiceInterfaceMock,
                $this->customerFacadeInterfaceMock,
            );

        $this->assertInstanceOf(
            ConditionalAvailabilityExpanderInterface::class,
            $this->conditionalAvailabilityCartConnectorBusinessFactory->createConditionalAvailabilityExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityDeliveryDateCleaner(): void
    {
        $this->assertInstanceOf(
            ConditionalAvailabilityDeliveryDateCleanerInterface::class,
            $this->conditionalAvailabilityCartConnectorBusinessFactory->createConditionalAvailabilityDeliveryDateCleaner(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityEnsureEarliestDate(): void
    {
        $this->assertInstanceOf(
            ConditionalAvailabilityEnsureEarliestDateInterface::class,
            $this->conditionalAvailabilityCartConnectorBusinessFactory->createConditionalAvailabilityEnsureEarliestDate(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityItemExpander(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE)
            ->willReturn($this->conditionalAvailabilityCartConnectorServiceInterfaceMock);

        $this->assertInstanceOf(
            ConditionalAvailabilityItemExpanderInterface::class,
            $this->conditionalAvailabilityCartConnectorBusinessFactory->createConditionalAvailabilityItemExpander(),
        );
    }
}
