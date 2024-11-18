<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\CancellationManager;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiEntityManager;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationRestApiFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\CancellationManager
     */
    protected MockObject|CancellationManager $cancellationManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiBusinessFactory
     */
    protected MockObject|ErpOrderCancellationRestApiBusinessFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiEntityManager
     */
    protected MockObject|ErpOrderCancellationRestApiEntityManager $entityManagerMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiFacade
     */
    protected ErpOrderCancellationRestApiFacade $facade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer
     */
    protected MockObject|RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer
     */
    protected MockObject|RestErpOrderCancellationResponseTransfer $restErpOrderCancellationResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer
     */
    protected MockObject|RestErpOrderCancellationCollectionResponseTransfer $restErpOrderCancellationCollectionResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->cancellationManagerMock = $this->getMockBuilder(CancellationManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(ErpOrderCancellationRestApiEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ErpOrderCancellationRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationRequestTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationResponseTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationCollectionResponseTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationCollectionResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ErpOrderCancellationRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
        $this->facade->setEntityManager($this->entityManagerMock);
    }

    /**
     * @return void
     */
    public function testAddErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCancellationManager')
            ->willReturn($this->cancellationManagerMock);

        $this->cancellationManagerMock->expects(static::atLeastOnce())
            ->method('addErpOrderCancellation')
            ->with($this->restErpOrderCancellationRequestTransferMock)
            ->willReturn($this->restErpOrderCancellationResponseTransferMock);

        static::assertEquals(
            $this->restErpOrderCancellationResponseTransferMock,
            $this->facade->addErpOrderCancellation(
                $this->restErpOrderCancellationRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCancellationManager')
            ->willReturn($this->cancellationManagerMock);

        $this->cancellationManagerMock->expects(static::atLeastOnce())
            ->method('getErpOrderCancellation')
            ->with($this->restErpOrderCancellationRequestTransferMock)
            ->willReturn($this->restErpOrderCancellationCollectionResponseTransferMock);

        static::assertEquals(
            $this->restErpOrderCancellationCollectionResponseTransferMock,
            $this->facade->getErpOrderCancellation(
                $this->restErpOrderCancellationRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCancellationManager')
            ->willReturn($this->cancellationManagerMock);

        $this->cancellationManagerMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->with($this->restErpOrderCancellationRequestTransferMock)
            ->willReturn($this->restErpOrderCancellationResponseTransferMock);

        static::assertEquals(
            $this->restErpOrderCancellationResponseTransferMock,
            $this->facade->updateErpOrderCancellation(
                $this->restErpOrderCancellationRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCancellationManager')
            ->willReturn($this->cancellationManagerMock);

        $this->cancellationManagerMock->expects(static::atLeastOnce())
            ->method('deleteErpOrderCancellation')
            ->with($this->restErpOrderCancellationRequestTransferMock)
            ->willReturn($this->restErpOrderCancellationResponseTransferMock);

        static::assertEquals(
            $this->restErpOrderCancellationResponseTransferMock,
            $this->facade->deleteErpOrderCancellation(
                $this->restErpOrderCancellationRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellationAmount(): void
    {
        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellationAmount')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        static::assertEquals(
            $this->erpOrderCancellationTransferMock,
            $this->facade->updateErpOrderCancellationAmount(
                $this->erpOrderCancellationTransferMock,
            ),
        );
    }
}
