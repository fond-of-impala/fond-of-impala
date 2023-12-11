<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepository;
use PHPUnit\Framework\MockObject\MockObject;

class StockStatusTriggerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface $productPageSearchFacadeMock;

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

        $this->productPageSearchFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->trigger = new StockStatusTrigger(
            $this->productAbstractReaderMock,
            $this->productPageSearchFacadeMock,
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

        $this->productPageSearchFacadeMock->expects(static::atLeastOnce())
            ->method('publishProductConcretes')
            ->with($productConcreteIds);

        $this->productAbstractReaderMock->expects(static::atLeastOnce())
            ->method('getProductAbstractIdsByConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($productAbstractIds);

        $this->productPageSearchFacadeMock->expects(static::atLeastOnce())
            ->method('publish')
            ->with($productAbstractIds);

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

        $this->productPageSearchFacadeMock->expects(static::atLeastOnce())
            ->method('publishProductConcretes')
            ->with($productConcreteIds);

        $this->productAbstractReaderMock->expects(static::atLeastOnce())
            ->method('getProductAbstractIdsByConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($productAbstractIds);

        $this->productPageSearchFacadeMock->expects(static::atLeastOnce())
            ->method('publish')
            ->with($productAbstractIds);

        $this->trigger->triggerDelta();
    }
}
