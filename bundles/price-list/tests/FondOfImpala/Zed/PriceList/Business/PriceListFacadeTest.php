<?php

namespace FondOfImpala\Zed\PriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Business\Model\PriceListReaderInterface;
use FondOfImpala\Zed\PriceList\Business\Model\PriceListWriterInterface;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListListTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Business\PriceListBusinessFactory
     */
    protected MockObject|PriceListBusinessFactory $priceListBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Business\Model\PriceListWriterInterface
     */
    protected MockObject|PriceListWriterInterface $priceListWriterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Business\Model\PriceListReaderInterface
     */
    protected MockObject|PriceListReaderInterface $priceListReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected MockObject|PriceListTransfer $priceListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    protected MockObject|PriceListCollectionTransfer $priceListCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\PriceListListTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceListListTransfer $priceListListTransferMock;

    /**
     * @var \FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface
     */
    protected PriceListFacadeInterface $priceListFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListReaderMock = $this->getMockBuilder(PriceListReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListWriterMock = $this->getMockBuilder(PriceListWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListBusinessFactoryMock = $this->getMockBuilder(PriceListBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCollectionTransferMock = $this->getMockBuilder(PriceListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListListTransferMock = $this->getMockBuilder(PriceListListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListFacade = new PriceListFacade();

        $this->priceListFacade->setFactory($this->priceListBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindPriceListById(): void
    {
        $this->priceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListReader')
            ->willReturn($this->priceListReaderMock);

        $this->priceListReaderMock->expects(static::atLeastOnce())
            ->method('findById')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListFacade->findPriceListById(
                $this->priceListTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindPriceListByName(): void
    {
        $this->priceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListReader')
            ->willReturn($this->priceListReaderMock);

        $this->priceListReaderMock->expects(static::atLeastOnce())
            ->method('findByName')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListFacade->findPriceListByName(
                $this->priceListTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeletePriceListById(): void
    {
        $this->priceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListWriter')
            ->willReturn($this->priceListWriterMock);

        $this->priceListWriterMock->expects(static::atLeastOnce())
            ->method('deleteById')
            ->with($this->priceListTransferMock);

        $this->priceListFacade->deletePriceListById(
            $this->priceListTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testDeletePriceListByName(): void
    {
        $this->priceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListWriter')
            ->willReturn($this->priceListWriterMock);

        $this->priceListWriterMock->expects(static::atLeastOnce())
            ->method('deleteByName')
            ->with($this->priceListTransferMock);

        $this->priceListFacade->deletePriceListByName(
            $this->priceListTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testGetPriceListCollection(): void
    {
        $this->priceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListReader')
            ->willReturn($this->priceListReaderMock);

        $this->priceListReaderMock->expects(static::atLeastOnce())
            ->method('findAll')
            ->willReturn($this->priceListCollectionTransferMock);

        static::assertEquals(
            $this->priceListCollectionTransferMock,
            $this->priceListFacade->getPriceListCollection(),
        );
    }

    /**
     * @return void
     */
    public function testCreatePriceList(): void
    {
        $this->priceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListWriter')
            ->willReturn($this->priceListWriterMock);

        $this->priceListWriterMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        $priceListTransfer = $this->priceListFacade->createPriceList($this->priceListTransferMock);

        static::assertEquals($this->priceListTransferMock, $priceListTransfer);
    }

    /**
     * @return void
     */
    public function testUpdatePriceList(): void
    {
        $this->priceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListWriter')
            ->willReturn($this->priceListWriterMock);

        $this->priceListWriterMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        $priceListTransfer = $this->priceListFacade->updatePriceList($this->priceListTransferMock);

        static::assertEquals($this->priceListTransferMock, $priceListTransfer);
    }

    /**
     * @return void
     */
    public function testFindPriceLists(): void
    {
        $this->priceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListReader')
            ->willReturn($this->priceListReaderMock);

        $this->priceListReaderMock->expects(static::atLeastOnce())
            ->method('findByPriceListList')
            ->with($this->priceListListTransferMock)
            ->willReturn($this->priceListListTransferMock);

        $priceListListTransfer = $this->priceListFacade->findPriceLists($this->priceListListTransferMock);

        static::assertEquals($this->priceListListTransferMock, $priceListListTransfer);
    }
}
