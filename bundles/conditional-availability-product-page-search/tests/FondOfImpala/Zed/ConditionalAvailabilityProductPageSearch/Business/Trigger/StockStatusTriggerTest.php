<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepository;
use PHPUnit\Framework\MockObject\MockObject;

class StockStatusTriggerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface
     */
    protected MockObject|ProductAbstractReaderInterface $productAbstractReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepository
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchRepository $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger\StockStatusTrigger
     */
    protected StockStatusTrigger $trigger;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productAbstractReaderMock = $this->getMockBuilder(ProductAbstractReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->trigger = new StockStatusTrigger(
            $this->productAbstractReaderMock,
            $this->eventBehaviorFacadeMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testTrigger(): void
    {
        $productConcreteIds = [1, 3];
        $productAbstractIds = [2];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findProductConcreteIdsToTrigger')
            ->willReturn($productConcreteIds);

        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('executeResolvedPluginsBySources')
            ->withConsecutive(
                [['product_concrete'], $productConcreteIds],
                [['product_abstract'], $productAbstractIds],
            );

        $this->productAbstractReaderMock->expects(static::atLeastOnce())
            ->method('getProductAbstractIdsByConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($productAbstractIds);

        $this->trigger->trigger();
    }

    /**
     * @return void
     */
    public function testTriggerWithoutProductConcreteIds(): void
    {
        $productConcreteIds = [];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findProductConcreteIdsToTrigger')
            ->willReturn($productConcreteIds);

        $this->eventBehaviorFacadeMock->expects(static::never())
            ->method('executeResolvedPluginsBySources');

        $this->productAbstractReaderMock->expects(static::never())
            ->method('getProductAbstractIdsByConcreteIds');

        $this->trigger->trigger();
    }

    /**
     * @return void
     */
    public function testTriggerWithoutProductAbstractIds(): void
    {
        $productConcreteIds = [1];
        $productAbstractIds = [];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findProductConcreteIdsToTrigger')
            ->willReturn($productConcreteIds);

        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('executeResolvedPluginsBySources')
            ->with(['product_concrete'], $productConcreteIds);

        $this->productAbstractReaderMock->expects(static::atLeastOnce())
            ->method('getProductAbstractIdsByConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($productAbstractIds);

        $this->trigger->trigger();
    }

    /**
     * @return void
     */
    public function testTriggerDelta(): void
    {
        $productConcreteIds = [1, 3];
        $productAbstractIds = [2];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findProductConcreteIdsForDeltaTrigger')
            ->willReturn($productConcreteIds);

        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('executeResolvedPluginsBySources')
            ->withConsecutive(
                [['product_concrete'], $productConcreteIds],
                [['product_abstract'], $productAbstractIds],
            );

        $this->productAbstractReaderMock->expects(static::atLeastOnce())
            ->method('getProductAbstractIdsByConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($productAbstractIds);

        $this->trigger->triggerDelta();
    }
}
