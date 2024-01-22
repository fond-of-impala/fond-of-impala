<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger;

use Codeception\Test\Unit;
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

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->trigger = new StockStatusTrigger(
            $this->eventBehaviorFacadeMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testTrigger(): void
    {
        $productAbstractIds = [2];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findProductAbstractIdsToTrigger')
            ->willReturn($productAbstractIds);

        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('executeResolvedPluginsBySources')
            ->with(['product_abstract'], $productAbstractIds);

        $this->trigger->trigger();
    }

    /**
     * @return void
     */
    public function testTriggerWithoutProductAbstractIds(): void
    {
        $productAbstractIds = [];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findProductAbstractIdsToTrigger')
            ->willReturn($productAbstractIds);

        $this->eventBehaviorFacadeMock->expects(static::never())
            ->method('executeResolvedPluginsBySources');

        $this->trigger->trigger();
    }

    /**
     * @return void
     */
    public function testTriggerDelta(): void
    {
        $productAbstractIds = [2];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findProductAbstractIdsForDeltaTrigger')
            ->willReturn($productAbstractIds);

        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('executeResolvedPluginsBySources')
            ->with(['product_abstract'], $productAbstractIds);

        $this->trigger->triggerDelta();
    }
}
