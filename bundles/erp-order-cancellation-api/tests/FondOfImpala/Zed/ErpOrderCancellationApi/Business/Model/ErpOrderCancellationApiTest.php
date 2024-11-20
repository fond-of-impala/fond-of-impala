<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepositoryInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiFilterTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Api\Business\Exception\EntityNotFoundException;
use Spryker\Zed\Api\Business\Exception\EntityNotSavedException;
use Throwable;

class ErpOrderCancellationApiTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected MockObject|ApiCollectionTransfer $apiCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected MockObject|ApiDataTransfer $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiFilterTransfer
     */
    protected MockObject|ApiFilterTransfer $apiFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected MockObject|ApiItemTransfer $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected MockObject|ApiRequestTransfer $apiRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface
     */
    protected MockObject|ErpOrderCancellationApiToApiFacadeInterface $erpOrderCancellationApiToApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface
     */
    protected MockObject|ErpOrderCancellationApiToErpOrderCancellationFacadeInterface $erpOrderCancellationApiToErpOrderCancellationFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepositoryInterface
     */
    protected MockObject|ErpOrderCancellationApiRepositoryInterface $erpOrderCancellationApiRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    protected MockObject|ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model\ErpOrderCancellationApiInterface
     */
    protected ErpOrderCancellationApiInterface $model;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiCollectionTransferMock = $this
            ->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this
            ->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiFilterTransferMock = $this
            ->getMockBuilder(ApiFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this
            ->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this
            ->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationResponseTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationApiToApiFacadeMock = $this
            ->getMockBuilder(ErpOrderCancellationApiToApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock = $this
            ->getMockBuilder(ErpOrderCancellationApiToErpOrderCancellationFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationApiRepositoryMock = $this
            ->getMockBuilder(ErpOrderCancellationApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new ErpOrderCancellationApi(
            $this->erpOrderCancellationApiToApiFacadeMock,
            $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock,
            $this->erpOrderCancellationApiRepositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $idErpOrderCancellation = 1;

        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn([]);

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('createErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects($this->atLeastOnce())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->erpOrderCancellationTransferMock->expects($this->atLeastOnce())
            ->method('getIdErpOrderCancellation')
            ->willReturn($idErpOrderCancellation);

        $this->erpOrderCancellationApiToApiFacadeMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->with($this->erpOrderCancellationTransferMock, (string)$idErpOrderCancellation)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->model->create($this->apiDataTransferMock);

        $this->assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testCreateWithException(): void
    {
        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn([]);

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('createErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects($this->atLeastOnce())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->expectException(EntityNotSavedException::class);

        $this->model->create($this->apiDataTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $idErpOrderCancellation = 1;

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('findErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn([]);

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects($this->atLeastOnce())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->erpOrderCancellationTransferMock->expects($this->atLeastOnce())
            ->method('getIdErpOrderCancellation')
            ->willReturn($idErpOrderCancellation);

        $this->erpOrderCancellationApiToApiFacadeMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->with($this->erpOrderCancellationTransferMock, (string)$idErpOrderCancellation)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->model->update($idErpOrderCancellation, $this->apiDataTransferMock);

        $this->assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testUpdateWithException(): void
    {
        $idErpOrderCancellation = 1;

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('findErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn([]);

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects($this->atLeastOnce())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->expectException(EntityNotSavedException::class);

        $this->model->update($idErpOrderCancellation, $this->apiDataTransferMock);
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $idErpOrderCancellation = 1;

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('findErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationApiToApiFacadeMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->with($this->erpOrderCancellationTransferMock, (string)$idErpOrderCancellation)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->model->get($idErpOrderCancellation);

        $this->assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testGetWithNoErpOrderCancellationTransfer(): void
    {
        $idErpOrderCancellation = 1;

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('findErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn(null);

        $this->expectException(EntityNotFoundException::class);

        $this->model->get($idErpOrderCancellation);
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $idErpOrderCancellation = 1;
        $criteriaJson = '{"rules" : [
            {
                "field": "state",
                "value": "new",
                "state": "state"
            }
        ]}';

        $apiCollectionData = [
            '0' => [
                'id_erp_order_cancellation' => 1,
            ],
        ];

        $this->apiRequestTransferMock->expects($this->atLeastOnce())
            ->method('getFilter')
            ->willReturn($this->apiFilterTransferMock);

        $this->apiFilterTransferMock->expects($this->atLeastOnce())
            ->method('getCriteriaJson')
            ->willReturn($criteriaJson);

        $this->apiFilterTransferMock->expects($this->atLeastOnce())
            ->method('setCriteriaJson');

        $this->apiRequestTransferMock->expects($this->atLeastOnce())
            ->method('setFilter')
            ->with($this->apiFilterTransferMock)
            ->willReturn($this->apiRequestTransferMock);

        $this->erpOrderCancellationApiRepositoryMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $this->apiCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($apiCollectionData);

         $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
             ->method('findErpOrderCancellationByIdErpOrderCancellation')
             ->with($idErpOrderCancellation)
             ->willReturn($this->erpOrderCancellationTransferMock);

         $this->erpOrderCancellationTransferMock->expects($this->atLeastOnce())
             ->method('toArray')
             ->willReturn([]);

         $this->apiCollectionTransferMock->expects($this->atLeastOnce())
             ->method('setData')
             ->willReturn($this->apiCollectionTransferMock);

        $responseTransfer = $this->model->find($this->apiRequestTransferMock);

        $this->assertEquals($this->apiCollectionTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testFindWithWrongState(): void
    {
        $criteriaJson = '{"rules" : [
            {
                "field": "state",
                "value": "completed",
                "state": "state"
            }
        ]}';

        $this->apiRequestTransferMock->expects($this->atLeastOnce())
            ->method('getFilter')
            ->willReturn($this->apiFilterTransferMock);

        $this->apiFilterTransferMock->expects($this->atLeastOnce())
            ->method('getCriteriaJson')
            ->willReturn($criteriaJson);

        $this->expectException(Throwable::class);

        $this->model->find($this->apiRequestTransferMock);
    }

    /**
     * @return void
     */
    public function testFindWithNoCriteriaJson(): void
    {
        $this->apiRequestTransferMock->expects($this->atLeastOnce())
            ->method('getFilter')
            ->willReturn($this->apiFilterTransferMock);

        $this->apiFilterTransferMock->expects($this->atLeastOnce())
            ->method('getCriteriaJson')
            ->willReturn(null);

        $this->erpOrderCancellationApiRepositoryMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $this->apiCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn([]);

        $this->apiCollectionTransferMock->expects($this->atLeastOnce())
            ->method('setData')
            ->willReturn($this->apiCollectionTransferMock);

        $responseTransfer = $this->model->find($this->apiRequestTransferMock);

        $this->assertEquals($this->apiCollectionTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testFindWithMissingRules(): void
    {
        $criteriaJson = '{}';

        $this->apiRequestTransferMock->expects($this->atLeastOnce())
            ->method('getFilter')
            ->willReturn($this->apiFilterTransferMock);

        $this->apiFilterTransferMock->expects($this->atLeastOnce())
            ->method('getCriteriaJson')
            ->willReturn($criteriaJson);

        $this->erpOrderCancellationApiRepositoryMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $this->apiCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn([]);

        $this->apiCollectionTransferMock->expects($this->atLeastOnce())
            ->method('setData')
            ->willReturn($this->apiCollectionTransferMock);

        $responseTransfer = $this->model->find($this->apiRequestTransferMock);

        $this->assertEquals($this->apiCollectionTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testFindNoData(): void
    {
        $criteriaJson = '{"rules" : [
            {
                "field": "field",
                "value": "1",
                "state": "state"
            }
        ]}';

        $apiCollectionData = [
            '0' => [
                'id_erp_order_' => 1,
            ],
        ];

        $this->erpOrderCancellationApiRepositoryMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $this->apiRequestTransferMock->expects($this->atLeastOnce())
            ->method('getFilter')
            ->willReturn($this->apiFilterTransferMock);

        $this->apiFilterTransferMock->expects($this->atLeastOnce())
            ->method('getCriteriaJson')
            ->willReturn($criteriaJson);

        $this->apiFilterTransferMock->expects($this->atLeastOnce())
            ->method('setCriteriaJson');

        $this->apiRequestTransferMock->expects($this->atLeastOnce())
            ->method('setFilter')
            ->with($this->apiFilterTransferMock)
            ->willReturn($this->apiRequestTransferMock);

        $this->erpOrderCancellationApiRepositoryMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $this->apiCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($apiCollectionData);

        $this->apiCollectionTransferMock->expects($this->atLeastOnce())
            ->method('setData')
            ->willReturn($this->apiCollectionTransferMock);

        $responseTransfer = $this->model->find($this->apiRequestTransferMock);

        $this->assertEquals($this->apiCollectionTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $idErpOrderCancellation = 1;

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('findErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock->expects($this->atLeastOnce())
            ->method('deleteErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation);

        $this->erpOrderCancellationApiToApiFacadeMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->with(null, (string)$idErpOrderCancellation)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->model->delete($idErpOrderCancellation);

        $this->assertEquals($this->apiItemTransferMock, $responseTransfer);
    }
}
