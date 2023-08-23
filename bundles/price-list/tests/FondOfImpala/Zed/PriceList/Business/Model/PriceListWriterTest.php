<?php

namespace FondOfImpala\Zed\PriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface;
use Generated\Shared\Transfer\PriceListTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListWriterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceList\Business\Model\PriceListWriter
     */
    protected PriceListWriter $priceListWriter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface
     */
    protected MockObject|PriceListEntityManagerInterface $priceListEntityManagerInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected MockObject|PriceListTransfer $priceListTransferMock;

    /**
     * @var int
     */
    protected int $idPriceList;

    /**
     * @var string
     */
    protected string $namePriceList;

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
        $this->priceListEntityManagerInterfaceMock->expects(static::atLeastOnce())
            ->method('persist')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
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
        $this->priceListTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn($this->idPriceList);

        $this->priceListEntityManagerInterfaceMock->expects(static::atLeastOnce())
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
        $this->priceListTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($this->namePriceList);

        $this->priceListEntityManagerInterfaceMock->expects(static::atLeastOnce())
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
        $this->priceListEntityManagerInterfaceMock->expects(static::atLeastOnce())
            ->method('persist')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
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
        $this->priceListEntityManagerInterfaceMock->expects(static::atLeastOnce())
            ->method('persist')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListWriter->update(
                $this->priceListTransferMock,
            ),
        );
    }
}
