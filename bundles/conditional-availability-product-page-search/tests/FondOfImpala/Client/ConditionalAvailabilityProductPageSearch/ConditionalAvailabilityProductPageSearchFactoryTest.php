<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class ConditionalAvailabilityProductPageSearchFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToCustomerClientInterface $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory
     */
    protected ConditionalAvailabilityProductPageSearchFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityProductPageSearchFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetCustomerClient(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::CLIENT_CUSTOMER)
            ->willReturn($this->customerClientMock);

        static::assertEquals($this->customerClientMock, $this->factory->getCustomerClient());
    }
}
