<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\QueryContainer;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderCriteriaTransfer;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\ApiQueryBuilder\Persistence\ApiQueryBuilderQueryContainerInterface;

class ErpOrderCancellationApiToApiQueryBuilderQueryContainerBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ApiQueryBuilder\Persistence\ApiQueryBuilderQueryContainerInterface
     */
    protected MockObject|ApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer
     */
    protected MockObject|ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\QueryContainer\ErpOrderCancellationApiToApiQueryBuilderQueryContainerBridge
     */
    protected ErpOrderCancellationApiToApiQueryBuilderQueryContainerBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected MockObject|ModelCriteria $modelCriteriaMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PropelQueryBuilderCriteriaTransfer
     */
    protected MockObject|PropelQueryBuilderCriteriaTransfer $propelQueryBuilderCriteriaTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiQueryBuilderQueryContainerMock = $this
            ->getMockBuilder(ApiQueryBuilderQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiQueryBuilderQueryTransferMock = $this
            ->getMockBuilder(ApiQueryBuilderQueryTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->modelCriteriaMock = $this
            ->getMockBuilder(ModelCriteria::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->propelQueryBuilderCriteriaTransferMock = $this
            ->getMockBuilder(PropelQueryBuilderCriteriaTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ErpOrderCancellationApiToApiQueryBuilderQueryContainerBridge(
            $this->apiQueryBuilderQueryContainerMock,
        );
    }

    /**
     * @return void
     */
    public function testToPropelQueryBuilderCriteria(): void
    {
        $this->apiQueryBuilderQueryContainerMock->expects(static::atLeastOnce())
            ->method('toPropelQueryBuilderCriteria')
            ->with($this->apiQueryBuilderQueryTransferMock)
            ->willReturn($this->propelQueryBuilderCriteriaTransferMock);

        $criteriaTransfer = $this->bridge->toPropelQueryBuilderCriteria($this->apiQueryBuilderQueryTransferMock);

        static::assertEquals($this->propelQueryBuilderCriteriaTransferMock, $criteriaTransfer);
    }

    /**
     * @return void
     */
    public function testBuildQueryFromRequest(): void
    {
        $this->apiQueryBuilderQueryContainerMock->expects(static::atLeastOnce())
            ->method('buildQueryFromRequest')
            ->with($this->modelCriteriaMock, $this->apiQueryBuilderQueryTransferMock)
            ->willReturn($this->modelCriteriaMock);

        $modelCriteria = $this->bridge
            ->buildQueryFromRequest($this->modelCriteriaMock, $this->apiQueryBuilderQueryTransferMock);

        static::assertEquals($this->modelCriteriaMock, $modelCriteria);
    }
}
