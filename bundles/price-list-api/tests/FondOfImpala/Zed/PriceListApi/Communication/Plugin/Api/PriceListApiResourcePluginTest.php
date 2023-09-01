<?php

namespace FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade;
use FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacadeInterface;
use FondOfImpala\Zed\PriceListApi\PriceListApiConfig;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListApiResourcePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api\PriceListApiResourcePlugin
     */
    protected PriceListApiResourcePlugin $priceListApiResourcePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected MockObject|ApiDataTransfer $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacadeInterface
     */
    protected MockObject|PriceListApiFacadeInterface $priceListFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected MockObject|ApiItemTransfer $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade
     */
    protected MockObject|PriceListApiFacade $priceListApiFacadeMock;

    /**
     * @var int
     */
    protected int $idProductList;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected MockObject|ApiRequestTransfer $apiRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected MockObject|ApiCollectionTransfer $apiCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListFacadeInterfaceMock = $this->getMockBuilder(PriceListApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListApiFacadeMock = $this->getMockBuilder(PriceListApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idProductList = 1;

        $this->priceListApiResourcePlugin = new PriceListApiResourcePlugin();

        $this->priceListApiResourcePlugin->setFacade($this->priceListApiFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetResourceName(): void
    {
        static::assertSame(PriceListApiConfig::RESOURCE_PRICE_LISTS, $this->priceListApiResourcePlugin->getResourceName());
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        $this->priceListApiFacadeMock->expects(static::atLeastOnce())
            ->method('addPriceList')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals($this->apiItemTransferMock, $this->priceListApiResourcePlugin->add($this->apiDataTransferMock));
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $this->priceListApiFacadeMock->expects(static::atLeastOnce())
            ->method('getPriceList')
            ->with($this->idProductList)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals($this->apiItemTransferMock, $this->priceListApiResourcePlugin->get($this->idProductList));
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->priceListApiFacadeMock->expects(static::atLeastOnce())
            ->method('updatePriceList')
            ->with($this->idProductList, $this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals($this->apiItemTransferMock, $this->priceListApiResourcePlugin->update($this->idProductList, $this->apiDataTransferMock));
    }

    /**
     * @return void
     */
    public function testRemove(): void
    {
        try {
            $this->priceListApiResourcePlugin->remove($this->idProductList);
        } catch (Exception) {
        }
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->priceListApiFacadeMock->expects(static::atLeastOnce())
            ->method('findPriceLists')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        static::assertEquals($this->apiCollectionTransferMock, $this->priceListApiResourcePlugin->find($this->apiRequestTransferMock));
    }
}
