<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence\OrderBudgetsBulkRestApiRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class OrderBudgetReaderTest extends Unit
{
    protected MockObject|OrderBudgetsBulkRestApiRepositoryInterface $repositoryMock;

    protected OrderBudgetReader $orderBudgetReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(OrderBudgetsBulkRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetReader = new OrderBudgetReader(
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByUuids(): void
    {
        $ids = [1, 4];
        $uuids = ['814c9e8d-3672-4370-a1ec-52207f4cb9b7', '3b5f4e83-ad5a-4a78-b62c-7b6c728283a0'];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getOrderBudgetIdsByUuids')
            ->with($uuids)
            ->willReturn($ids);

        static::assertEquals(
            $ids,
            $this->orderBudgetReader->getIdsByUuids($uuids),
        );
    }
}
