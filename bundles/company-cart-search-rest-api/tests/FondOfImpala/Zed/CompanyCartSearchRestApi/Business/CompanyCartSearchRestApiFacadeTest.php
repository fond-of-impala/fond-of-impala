<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander\QueryJoinCollectionExpanderInterface;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyCartSearchRestApiFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\CompanyCartSearchRestApiBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCartSearchRestApiBusinessFactory $factoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander\QueryJoinCollectionExpanderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QueryJoinCollectionExpanderInterface $queryJoinCollectionExpanderMock;

    /**
     * @var array<\Generated\Shared\Transfer\FilterFieldTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $filterFieldTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\QueryJoinCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QueryJoinCollectionTransfer $queryJoinCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\CompanyCartSearchRestApiFacade
     */
    protected CompanyCartSearchRestApiFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyCartSearchRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryJoinCollectionExpanderMock = $this->getMockBuilder(QueryJoinCollectionExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filterFieldTransferMocks = [
            $this->getMockBuilder(FilterFieldTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->queryJoinCollectionTransferMock = $this->getMockBuilder(QueryJoinCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyCartSearchRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQueryJoinCollection(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQueryJoinCollectionExpander')
            ->willReturn($this->queryJoinCollectionExpanderMock);

        $this->queryJoinCollectionExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->filterFieldTransferMocks, $this->queryJoinCollectionTransferMock)
            ->willReturn($this->queryJoinCollectionTransferMock);

        static::assertEquals(
            $this->queryJoinCollectionTransferMock,
            $this->facade->expandQueryJoinCollection(
                $this->filterFieldTransferMocks,
                $this->queryJoinCollectionTransferMock,
            ),
        );
    }
}
