<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpanderInterface;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;

class BusinessCentralOrderBudgetsBulkRestApiBusinessFactoryTest extends Unit
{
    protected BusinessCentralOrderBudgetsBulkRestApiBusinessFactory $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiRepository
     */
    protected MockObject|BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(BusinessCentralOrderBudgetsBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new BusinessCentralOrderBudgetsBulkRestApiBusinessFactory();
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateRestOrderBudgetsBulkRequestExpander(): void
    {
        static::assertInstanceOf(
            RestOrderBudgetsBulkRequestExpanderInterface::class,
            $this->factory->createRestOrderBudgetsBulkRequestExpander(),
        );
    }
}
