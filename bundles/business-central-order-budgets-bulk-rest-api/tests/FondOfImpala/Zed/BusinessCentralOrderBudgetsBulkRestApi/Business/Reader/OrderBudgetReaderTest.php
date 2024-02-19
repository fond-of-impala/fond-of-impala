<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface
     */
    protected OrderBudgetReaderInterface $reader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface
     */
    protected MockObject|BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new OrderBudgetReader($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testGetIdsByCustomerReferenceAndDebtorNumbers(): void
    {
        $customerReference = 'customer-reference';
        $debtorNumbers = ['11111'];
        $ids = [1];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getOrderBudgetIdsByCustomerReferenceAndDebtorNumbers')
            ->with($customerReference, $debtorNumbers)
            ->willReturn($ids);

        static::assertEquals(
            $ids,
            $this->reader->getIdsByCustomerReferenceAndDebtorNumbers($customerReference, $debtorNumbers),
        );
    }
}
