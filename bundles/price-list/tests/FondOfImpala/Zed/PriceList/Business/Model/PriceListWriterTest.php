<?php

namespace FondOfImpala\Zed\PriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface;
use Generated\Shared\Transfer\PriceListTransfer;

class PriceListWriterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceList\Business\Model\PriceListWriter
     */
    protected $priceListWriter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface
     */
    protected $priceListEntityManagerInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected $priceListTransferMock;

    /**
     * @var int
     */
    protected $idPriceList;

    /**
     * @var string
     */
    protected $namePriceList;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceListEntityManagerInterfaceMock = $this->getMockBuilder(PriceListEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idPriceList = 1;

        $this->namePriceList = 'name-price-list';

        $this->priceListWriter = new PriceListWriter(
            $this->priceListEntityManagerInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $this->priceListEntityManagerInterfaceMock->expects($this->atLeastOnce())
            ->method('persist')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        $this->assertInstanceOf(
            PriceListTransfer::class,
            $this->priceListWriter->persist(
                $this->priceListTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteById(): void
    {
        $this->priceListTransferMock->expects($this->atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn($this->idPriceList);

        $this->priceListEntityManagerInterfaceMock->expects($this->atLeastOnce())
            ->method('deleteById')
            ->with($this->idPriceList);

        $this->priceListWriter->deleteById(
            $this->priceListTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteByName(): void
    {
        $this->priceListTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->namePriceList);

        $this->priceListEntityManagerInterfaceMock->expects($this->atLeastOnce())
            ->method('deleteByName')
            ->with($this->namePriceList);

        $this->priceListWriter->deleteByName(
            $this->priceListTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->priceListEntityManagerInterfaceMock->expects($this->atLeastOnce())
            ->method('persist')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        $this->assertInstanceOf(
            PriceListTransfer::class,
            $this->priceListWriter->create(
                $this->priceListTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->priceListEntityManagerInterfaceMock->expects($this->atLeastOnce())
            ->method('persist')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        $this->assertInstanceOf(
            PriceListTransfer::class,
            $this->priceListWriter->update(
                $this->priceListTransferMock,
            ),
        );
    }
}
