<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Handler\ErpOrderCancellationItemHandlerInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationWriterInterface;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class ErpOrderCancellationFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    protected MockObject|ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationWriterInterface
     */
    protected MockObject|ErpOrderCancellationWriterInterface $erpOrderCancellationWriterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface
     */
    protected MockObject|ReaderInterface $erpOrderCancellationReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\Handler\ErpOrderCancellationItemHandlerInterface
     */
    protected MockObject|ErpOrderCancellationItemHandlerInterface $erpOrderCancellationItemHandlerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationBusinessFactory
     */
    protected MockObject|ErpOrderCancellationBusinessFactory $factoryMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacade
     */
    protected ErpOrderCancellationFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationResponseTransferMock = $this->getMockBuilder(ErpOrderCancellationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationReaderMock = $this->getMockBuilder(ReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationWriterMock = $this->getMockBuilder(ErpOrderCancellationWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemHandlerMock = $this->getMockBuilder(ErpOrderCancellationItemHandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ErpOrderCancellationBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ErpOrderCancellationFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationWriter')
            ->willReturn($this->erpOrderCancellationWriterMock);

        $this->erpOrderCancellationWriterMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationResponseTransfer::class,
            $this->facade->createErpOrderCancellation($this->erpOrderCancellationTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationWriter')
            ->willReturn($this->erpOrderCancellationWriterMock);

        $this->erpOrderCancellationWriterMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationResponseTransfer::class,
            $this->facade->updateErpOrderCancellation($this->erpOrderCancellationTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testDeleteErpOrderCancellationByIdErpOrderCancellation(): void
    {
        $idErpOrderCancellation = 1;

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationWriter')
            ->willReturn($this->erpOrderCancellationWriterMock);

        $this->erpOrderCancellationWriterMock->expects(static::atLeastOnce())
            ->method('delete')
            ->with($idErpOrderCancellation);

        $this->facade->deleteErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);
    }

    /**
     * @return void
     */
    public function testFindErpOrderCancellationByIdErpOrderCancellation(): void
    {
        $idErpOrderCancellation = 1;

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationReader')
            ->willReturn($this->erpOrderCancellationReaderMock);

        $this->erpOrderCancellationReaderMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation);

        $this->facade->findErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);
    }

    /**
     * @return void
     */
    public function testPersistErpOrderCancellationItem(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationItemHandler')
            ->willReturn($this->erpOrderCancellationItemHandlerMock);

        $this->erpOrderCancellationItemHandlerMock->expects(static::atLeastOnce())
            ->method('handle')
            ->with($this->erpOrderCancellationTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->facade->persistErpOrderCancellationItem($this->erpOrderCancellationTransferMock),
        );
    }
}
