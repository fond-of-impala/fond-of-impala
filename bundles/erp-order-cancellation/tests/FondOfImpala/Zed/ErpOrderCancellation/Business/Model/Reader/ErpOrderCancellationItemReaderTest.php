<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationItemReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface
     */
    protected MockObject|ErpOrderCancellationRepositoryInterface $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected MockObject|ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface
     */
    protected ErpOrderCancellationItemReaderInterface $reader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationItemTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this
            ->getMockBuilder(ErpOrderCancellationRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new ErpOrderCancellationItemReader($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testFindErpOrderCancellationItemsByIdErpOrderCancellation(): void
    {
        $idErpOrderCancellation = 1;

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationItemsByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn(new ArrayObject());

        static::assertInstanceOf(
            ArrayObject::class,
            $this->reader->findErpOrderCancellationItemsByIdErpOrderCancellation($idErpOrderCancellation),
        );
    }

    /**
     * @return void
     */
    public function testFindErpOrderCancellationItemByIdErpOrderCancellationAndSku(): void
    {
        $fkErpOrderCancellation = 1;
        $sku = 'sku';
        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationItemByIdErpOrderCancellationAndSku')
            ->with($fkErpOrderCancellation, $sku)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationItemTransfer::class,
            $this->reader
                ->findErpOrderCancellationItemByIdErpOrderCancellationAndSku($fkErpOrderCancellation, $sku),
        );
    }
}
