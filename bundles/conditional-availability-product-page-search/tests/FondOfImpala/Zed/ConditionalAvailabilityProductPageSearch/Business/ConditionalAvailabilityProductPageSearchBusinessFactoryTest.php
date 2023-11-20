<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductConcretePageSearchExpander;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductPageLoadExpander;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReader;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger\StockStatusTriggerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityProductPageSearchBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchBusinessFactory
     */
    protected ConditionalAvailabilityProductPageSearchBusinessFactory $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface $productPageSearchFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepository
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchRepository $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPageSearchFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityProductPageSearchBusinessFactory();
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateProductAbstractReader(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT)
            ->willReturn($this->productFacadeMock);

        static::assertInstanceOf(
            ProductAbstractReader::class,
            $this->factory->createProductAbstractReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateProductConcretePageSearchExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY)
            ->willReturn($this->conditionalAvailabilityFacadeMock);

        static::assertInstanceOf(
            ProductConcretePageSearchExpander::class,
            $this->factory->createProductConcretePageSearchExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateProductPageLoadExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT],
                [ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY],
            )->willReturnOnConsecutiveCalls(true, true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT],
                [ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY],
            )->willReturn($this->productFacadeMock, $this->conditionalAvailabilityFacadeMock);

        static::assertInstanceOf(
            ProductPageLoadExpander::class,
            $this->factory->createProductPageLoadExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateStockStatusTrigger(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT],
                [ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT_PAGE_SEARCH],
            )->willReturnOnConsecutiveCalls(true, true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT],
                [ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT_PAGE_SEARCH],
            )->willReturn($this->productFacadeMock, $this->productPageSearchFacadeMock);

        static::assertInstanceOf(
            StockStatusTriggerInterface::class,
            $this->factory->createStockStatusTrigger(),
        );
    }
}
