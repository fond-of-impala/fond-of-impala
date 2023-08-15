<?php

namespace FondOfImpala\Zed\PriceList\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Persistence\PriceListRepositoryInterface;
use FondOfOryx\Zed\PriceListExtension\Dependency\Plugin\SearchPriceListQueryExpanderPluginInterface;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListListTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Persistence\PriceListRepositoryInterface
     */
    protected MockObject|PriceListRepositoryInterface $repositoryMock;

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
     * @var array<\FondOfOryx\Zed\PriceListExtension\Dependency\Plugin\SearchPriceListQueryExpanderPluginInterface|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $searchPriceListQueryExpanderPluginMocks;

    /**
     * @var \Generated\Shared\Transfer\QueryJoinCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QueryJoinCollectionTransfer $queryJoinCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\PriceList\Business\Model\PriceListReader
     */
    protected PriceListReader $priceListReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->repositoryMock = $this->getMockBuilder(PriceListRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCollectionTransferMock = $this->getMockBuilder(PriceListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListListTransferMock = $this->getMockBuilder(PriceListListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchPriceListQueryExpanderPluginMocks = [
            $this->getMockBuilder(SearchPriceListQueryExpanderPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->queryJoinCollectionTransferMock = $this->getMockBuilder(QueryJoinCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListReader = new PriceListReader(
            $this->repositoryMock,
            $this->searchPriceListQueryExpanderPluginMocks,
        );
    }

    /**
     * @return void
     */
    public function testFindById(): void
    {
        $idPriceList = 1;

        $this->priceListTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceListOrFail')
            ->willReturn($idPriceList);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getById')
            ->with($idPriceList)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListReader->findById(
                $this->priceListTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindByName(): void
    {
        $priceListName = 'foo';

        $this->priceListTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($priceListName);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getByName')
            ->with($priceListName)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListReader->findByName(
                $this->priceListTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindAll(): void
    {
        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getAll')
            ->willReturn($this->priceListCollectionTransferMock);

        static::assertEquals(
            $this->priceListCollectionTransferMock,
            $this->priceListReader->findAll(),
        );
    }

    /**
     * @return void
     */
    public function testFindByPriceListList(): void
    {
        $filterFieldTransfers = [];

        $this->priceListListTransferMock->expects(static::atLeastOnce())
            ->method('getFilterFields')
            ->willReturn(new ArrayObject($filterFieldTransfers));

        $this->searchPriceListQueryExpanderPluginMocks[0]->expects(static::atLeastOnce())
            ->method('isApplicable')
            ->with($filterFieldTransfers)
            ->willReturn(true);

        $this->searchPriceListQueryExpanderPluginMocks[0]->expects(static::atLeastOnce())
            ->method('expand')
            ->with(
                $filterFieldTransfers,
                static::callback(
                    static fn (QueryJoinCollectionTransfer $queryJoinCollectionTransfer): bool => $queryJoinCollectionTransfer->getQueryJoins()->count() === 0,
                ),
            )->willReturn($this->queryJoinCollectionTransferMock);

        $this->priceListListTransferMock->expects(static::atLeastOnce())
            ->method('setQueryJoins')
            ->with($this->queryJoinCollectionTransferMock)
            ->willReturn($this->priceListListTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findPriceLists')
            ->with($this->priceListListTransferMock)
            ->willReturn($this->priceListListTransferMock);

        $priceListListTransfer = $this->priceListReader->findByPriceListList($this->priceListListTransferMock);

        static::assertEquals($this->priceListListTransferMock, $priceListListTransfer);
    }
}
