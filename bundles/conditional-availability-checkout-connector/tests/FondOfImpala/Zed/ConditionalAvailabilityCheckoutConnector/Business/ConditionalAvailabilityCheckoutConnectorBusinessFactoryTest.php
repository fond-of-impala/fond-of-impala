<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Model\AvailabilitiesChecker;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\ConditionalAvailabilityCheckoutConnectorDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityCheckoutConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Kernel\Container&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected Container|MockObject $containerMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface|MockObject $conditionalAvailabilityFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface|MockObject $conditionalAvailabilityServiceMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorBusinessFactory
     */
    protected ConditionalAvailabilityCheckoutConnectorBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityCheckoutConnectorBusinessFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateAvailabilitiesChecker(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityCheckoutConnectorDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityCheckoutConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY],
            )
            ->willReturnOnConsecutiveCalls(
                $this->conditionalAvailabilityFacadeMock,
                $this->conditionalAvailabilityServiceMock,
            );

        static::assertInstanceOf(
            AvailabilitiesChecker::class,
            $this->factory->createAvailabilitiesChecker(),
        );
    }
}
