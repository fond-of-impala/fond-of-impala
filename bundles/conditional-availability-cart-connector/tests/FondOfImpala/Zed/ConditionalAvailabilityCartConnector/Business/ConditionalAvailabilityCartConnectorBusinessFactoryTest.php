<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\QuoteExpander;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleaner;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDate;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpander;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityCartConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Kernel\Container&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected Container|MockObject $containerMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorToCustomerFacadeInterface|MockObject $customerFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface|MockObject $conditionalAvailabilityFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface|MockObject $conditionalAvailabilityServiceMock;

    /**
     * @var (\FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorServiceInterface|MockObject $serviceMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepository&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorRepository|MockObject $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorBusinessFactory
     */
    protected ConditionalAvailabilityCartConnectorBusinessFactory $businessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->businessFactory = new ConditionalAvailabilityCartConnectorBusinessFactory();
        $this->businessFactory->setContainer($this->containerMock);
        $this->businessFactory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testQuoteExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityCartConnectorDependencyProvider::FACADE_CUSTOMER],
                [ConditionalAvailabilityCartConnectorDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY],
            )->willReturnOnConsecutiveCalls(
                $this->customerFacadeMock,
                $this->conditionalAvailabilityFacadeMock,
                $this->conditionalAvailabilityServiceMock,
                $this->conditionalAvailabilityServiceMock,
                $this->conditionalAvailabilityServiceMock,
                $this->conditionalAvailabilityServiceMock,
            );

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn(new DateTime());

        static::assertInstanceOf(
            QuoteExpander::class,
            $this->businessFactory->createQuoteExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityDeliveryDateCleaner(): void
    {
        static::assertInstanceOf(
            ConditionalAvailabilityDeliveryDateCleaner::class,
            $this->businessFactory->createConditionalAvailabilityDeliveryDateCleaner(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityEnsureEarliestDate(): void
    {
        static::assertInstanceOf(
            ConditionalAvailabilityEnsureEarliestDate::class,
            $this->businessFactory->createConditionalAvailabilityEnsureEarliestDate(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityItemExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE)
            ->willReturn($this->serviceMock);

        static::assertInstanceOf(
            ConditionalAvailabilityItemExpander::class,
            $this->businessFactory->createConditionalAvailabilityItemExpander(),
        );
    }
}
