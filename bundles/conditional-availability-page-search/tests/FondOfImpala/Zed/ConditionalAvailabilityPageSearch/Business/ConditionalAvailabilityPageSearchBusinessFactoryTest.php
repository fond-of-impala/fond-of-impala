<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchPublisher;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchUnpublisher;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManager;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityPageSearchBusinessFactoryTest extends Unit
{
    protected MockObject|ConditionalAvailabilityPageSearchQueryContainer $queryContainerMock;

    protected MockObject|ConditionalAvailabilityPageSearchEntityManager $entityManagerMock;

    protected MockObject|Container $containerMock;

    protected MockObject|ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface $utilEncodingServiceMock;

    protected ConditionalAvailabilityPageSearchBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->queryContainerMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchQueryContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->utilEncodingServiceMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityPageSearchBusinessFactory();
        $this->factory->setQueryContainer($this->queryContainerMock);
        $this->factory->setEntityManager($this->entityManagerMock);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityPeriodPageSearchPublisher(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_DATA_EXPANDER],
                [ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_SEARCH_DATA_EXPANDER],
                [ConditionalAvailabilityPageSearchDependencyProvider::SERVICE_UTIL_ENCODING],
            )->willReturnOnConsecutiveCalls(
                [],
                [],
                $this->utilEncodingServiceMock,
            );

        static::assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchPublisher::class,
            $this->factory->createConditionalAvailabilityPeriodPageSearchPublisher(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityPeriodPageSearchUnpublisher(): void
    {
        static::assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchUnpublisher::class,
            $this->factory->createConditionalAvailabilityPeriodPageSearchUnpublisher(),
        );
    }
}
