<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpander;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Persister\OrderBudgetPersister;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Processor\BulkProcessor;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiDependencyProvider;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence\OrderBudgetsBulkRestApiRepository;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class OrderBudgetsBulkRestApiBusinessFactoryTest extends Unit
{
    protected Container|MockObject $containerMock;

    protected MockObject|OrderBudgetsBulkRestApiToEventFacadeInterface $eventFacadeMock;

    protected OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface|MockObject $orderBudgetFacadeMock;

    protected OrderBudgetsBulkRestApiRepository|MockObject $repositoryMock;

    protected OrderBudgetsBulkRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this->getMockBuilder(OrderBudgetsBulkRestApiToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetFacadeMock = $this->getMockBuilder(OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(OrderBudgetsBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new OrderBudgetsBulkRestApiBusinessFactory();
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateOrderBudgetPersister(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(OrderBudgetsBulkRestApiDependencyProvider::FACADE_ORDER_BUDGET)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(OrderBudgetsBulkRestApiDependencyProvider::FACADE_ORDER_BUDGET)
            ->willReturn($this->orderBudgetFacadeMock);

        static::assertInstanceOf(
            OrderBudgetPersister::class,
            $this->factory->createOrderBudgetPersister()
        );
    }

    /**
     * @return void
     */
    public function testCreateRestOrderBudgetsBulkRequestExpander(): void
    {
        static::assertInstanceOf(
            RestOrderBudgetsBulkRequestExpander::class,
            $this->factory->createRestOrderBudgetsBulkRequestExpander()
        );
    }

    /**
     * @return void
     */
    public function testCreateBulkProcessor(): void
    {
        $this->containerMock->expects(static::exactly(2))
            ->method('has')
            ->willReturn(true);

        $matcher = static::exactly(2);

        $this->containerMock->expects($matcher)
            ->method('get')
            ->willReturnCallback(
                fn(string $value) => match ($matcher->getInvocationCount()) {
                    1 => $this->eventFacadeMock,
                    2 => [],
                    default => throw new LogicException(),
                }
            );

        static::assertInstanceOf(
            BulkProcessor::class,
            $this->factory->createBulkProcessor()
        );
    }
}
