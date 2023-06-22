<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model\ConditionalAvailabilityBulkApi;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\ConditionalAvailabilityBulkApiDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToApiFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToProductFacadeInterface;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityBulkApiBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToProductFacadeInterface
     */
    protected $productFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToApiFacadeInterface
     */
    protected $apiQueryContainerMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\ConditionalAvailabilityBulkApiBusinessFactory
     */
    protected $businessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productFacadeMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiToProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiQueryContainerMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiToApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->businessFactory = new ConditionalAvailabilityBulkApiBusinessFactory();
        $this->businessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilitiesBulkApi(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [ConditionalAvailabilityBulkApiDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityBulkApiDependencyProvider::FACADE_PRODUCT],
                [ConditionalAvailabilityBulkApiDependencyProvider::FACADE_API],
            )->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityBulkApiDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY],
                [ConditionalAvailabilityBulkApiDependencyProvider::FACADE_PRODUCT],
                [ConditionalAvailabilityBulkApiDependencyProvider::FACADE_API],
            )
            ->willReturnOnConsecutiveCalls(
                $this->conditionalAvailabilityFacadeMock,
                $this->productFacadeMock,
                $this->apiQueryContainerMock,
            );

        static::assertInstanceOf(
            ConditionalAvailabilityBulkApi::class,
            $this->businessFactory->createConditionalAvailabilitiesBulkApi(),
        );
    }
}
