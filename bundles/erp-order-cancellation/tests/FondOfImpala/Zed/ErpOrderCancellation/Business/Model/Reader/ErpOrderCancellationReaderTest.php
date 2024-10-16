<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface
     */
    protected MockObject|ErpOrderCancellationRepositoryInterface $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface
     */
    protected ReaderInterface $reader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this
            ->getMockBuilder(ErpOrderCancellationRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new ErpOrderCancellationReader($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testFindErpOrderCancellationByIdErpOrderCancellation(): void
    {
        $idErpOrderCancellation = 1;

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn($this->erpOrderCancellationTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->reader->findErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation),
        );
    }
}
