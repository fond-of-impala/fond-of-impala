<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model\ErpOrderCancellationApi;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator\ErpOrderCancellationApiValidatorInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationApiFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected MockObject|ApiDataTransfer $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected MockObject|ApiCollectionTransfer $apiCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected MockObject|ApiItemTransfer $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected MockObject|ApiRequestTransfer $apiRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator\ErpOrderCancellationApiValidatorInterface
     */
    protected MockObject|ErpOrderCancellationApiValidatorInterface $erpOrderCancellationApiValidatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model\ErpOrderCancellationApi
     */
    protected MockObject|ErpOrderCancellationApi $erpOrderCancellationApiMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiBusinessFactory
     */
    protected MockObject|ErpOrderCancellationApiBusinessFactory $factoryMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiFacade
     */
    protected ErpOrderCancellationApiFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationApiValidatorMock = $this->getMockBuilder(ErpOrderCancellationApiValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationApiMock = $this->getMockBuilder(ErpOrderCancellationApi::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ErpOrderCancellationApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ErpOrderCancellationApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationApi')
            ->willReturn($this->erpOrderCancellationApiMock);

        $this->erpOrderCancellationApiMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->facade->createErpOrderCancellation($this->apiDataTransferMock);

        static::assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellation(): void
    {
        $idErpOrderCancellation = 1;

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationApi')
            ->willReturn($this->erpOrderCancellationApiMock);

        $this->erpOrderCancellationApiMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($idErpOrderCancellation, $this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->facade
            ->updateErpOrderCancellation($idErpOrderCancellation, $this->apiDataTransferMock);

        static::assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testGetErpOrderCancellation(): void
    {
        $idErpOrderCancellation = 1;

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationApi')
            ->willReturn($this->erpOrderCancellationApiMock);

        $this->erpOrderCancellationApiMock->expects(static::atLeastOnce())
            ->method('get')
            ->with($idErpOrderCancellation)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->facade->getErpOrderCancellation($idErpOrderCancellation);

        static::assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testFindErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationApi')
            ->willReturn($this->erpOrderCancellationApiMock);

        $this->erpOrderCancellationApiMock->expects(static::atLeastOnce())
            ->method('find')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $responseTransfer = $this->facade
            ->findErpOrderCancellations($this->apiRequestTransferMock);

        static::assertEquals($this->apiCollectionTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testDeleteErpOrderCancellation(): void
    {
        $idErpOrderCancellation = 1;

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationApi')
            ->willReturn($this->erpOrderCancellationApiMock);

        $this->erpOrderCancellationApiMock->expects(static::atLeastOnce())
            ->method('delete')
            ->with($idErpOrderCancellation)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->facade
            ->deleteErpOrderCancellation($idErpOrderCancellation);

        static::assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testValidateErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationApiValidator')
            ->willReturn($this->erpOrderCancellationApiValidatorMock);

        $this->erpOrderCancellationApiValidatorMock->expects(static::atLeastOnce())
            ->method('validate')
            ->with($this->apiRequestTransferMock)
            ->willReturn([]);

        static::assertIsArray(
            $this->facade
                ->validateErpOrderCancellation($this->apiRequestTransferMock),
        );
    }
}
