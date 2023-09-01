<?php

namespace FondOfImpala\Zed\PriceListApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceListApi\Business\Hydrator\PriceProductsHydratorInterface;
use FondOfImpala\Zed\PriceListApi\Business\Model\PriceListApi;
use FondOfImpala\Zed\PriceListApi\Business\Validator\PriceListApiValidatorInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListApiFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade
     */
    protected PriceListApiFacade $priceListApiFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected MockObject|ApiDataTransfer $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\PriceListApiBusinessFactory
     */
    protected MockObject|PriceListApiBusinessFactory $priceListApiBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\Model\PriceListApi
     */
    protected MockObject|PriceListApi $priceListApiMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected MockObject|ApiItemTransfer $apiItemTransferMock;

    /**
     * @var int
     */
    protected int $idPriceList;

    /**
     * @var array<\Generated\Shared\Transfer\PriceProductTransfer>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $priceProductTransferMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\Hydrator\PriceProductsHydratorInterface
     */
    protected MockObject|PriceProductsHydratorInterface $priceProductsHydratorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected MockObject|ApiRequestTransfer $apiRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected MockObject|ApiCollectionTransfer $apiCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\Validator\PriceListApiValidatorInterface
     */
    protected MockObject|PriceListApiValidatorInterface $priceListApiValidatorInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListApiBusinessFactoryMock = $this->getMockBuilder(PriceListApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListApiMock = $this->getMockBuilder(PriceListApi::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductTransferMocks = [
            $this->getMockBuilder(PriceProductTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->priceProductsHydratorMock = $this->getMockBuilder(PriceProductsHydratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListApiValidatorInterfaceMock = $this->getMockBuilder(PriceListApiValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idPriceList = 1;

        $this->priceListApiFacade = new PriceListApiFacade();
        $this->priceListApiFacade->setFactory($this->priceListApiBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testAddPriceList(): void
    {
        $this->priceListApiBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createProductListApi')
            ->willReturn($this->priceListApiMock);

        $this->priceListApiMock->expects(static::atLeastOnce())
            ->method('add')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->priceListApiFacade->addPriceList($this->apiDataTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdatePriceList(): void
    {
        $this->priceListApiBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createProductListApi')
            ->willReturn($this->priceListApiMock);

        $this->priceListApiMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->idPriceList, $this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->priceListApiFacade->updatePriceList($this->idPriceList, $this->apiDataTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testHydrateProductId(): void
    {
        $this->priceListApiBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceProductsHydrator')
            ->willReturn($this->priceProductsHydratorMock);

        $this->priceProductsHydratorMock->expects(static::atLeastOnce())
            ->method('hydrate')
            ->with($this->priceProductTransferMocks)
            ->willReturn($this->priceProductTransferMocks);

        static::assertEquals(
            $this->priceProductTransferMocks,
            $this->priceListApiFacade->hydratePriceProductsWithProductIds(
                $this->priceProductTransferMocks,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetPriceList(): void
    {
        $this->priceListApiBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createProductListApi')
            ->willReturn($this->priceListApiMock);

        $this->priceListApiMock->expects(static::atLeastOnce())
            ->method('get')
            ->with($this->idPriceList)
            ->willReturn($this->apiItemTransferMock);

        static::assertInstanceOf(ApiItemTransfer::class, $this->priceListApiFacade->getPriceList($this->idPriceList));
    }

    /**
     * @return void
     */
    public function testFindPriceLists(): void
    {
        $this->priceListApiBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createProductListApi')
            ->willReturn($this->priceListApiMock);

        $this->priceListApiMock->expects(static::atLeastOnce())
            ->method('find')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        static::assertInstanceOf(ApiCollectionTransfer::class, $this->priceListApiFacade->findPriceLists($this->apiRequestTransferMock));
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->priceListApiBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListApiValidator')
            ->willReturn($this->priceListApiValidatorInterfaceMock);

        $this->priceListApiValidatorInterfaceMock->expects(static::atLeastOnce())
            ->method('validate')
            ->with($this->apiRequestTransferMock)
            ->willReturn([]);

        static::assertIsArray($this->priceListApiFacade->validate($this->apiRequestTransferMock));
    }
}
