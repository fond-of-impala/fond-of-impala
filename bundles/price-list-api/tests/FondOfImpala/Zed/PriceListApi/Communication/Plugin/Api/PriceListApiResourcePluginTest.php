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

class PriceListApiResourcePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api\PriceListApiResourcePlugin
     */
    protected $priceListApiResourcePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacadeInterface
     */
    protected $priceListFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade
     */
    protected $priceListApiFacadeMock;

    /**
     * @var int
     */
    protected $idProductList;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected $apiRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected $apiCollectionTransferMock;

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
        $this->assertSame(PriceListApiConfig::RESOURCE_PRICE_LISTS, $this->priceListApiResourcePlugin->getResourceName());
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        $this->priceListApiFacadeMock->expects($this->atLeastOnce())
            ->method('addPriceList')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->priceListApiResourcePlugin->add($this->apiDataTransferMock));
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $this->priceListApiFacadeMock->expects($this->atLeastOnce())
            ->method('getPriceList')
            ->with($this->idProductList)
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->priceListApiResourcePlugin->get($this->idProductList));
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->priceListApiFacadeMock->expects($this->atLeastOnce())
            ->method('updatePriceList')
            ->with($this->idProductList, $this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->priceListApiResourcePlugin->update($this->idProductList, $this->apiDataTransferMock));
    }

    /**
     * @return void
     */
    public function testRemove(): void
    {
        try {
            $this->priceListApiResourcePlugin->remove($this->idProductList);
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->priceListApiFacadeMock->expects($this->atLeastOnce())
            ->method('findPriceLists')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $this->assertInstanceOf(ApiCollectionTransfer::class, $this->priceListApiResourcePlugin->find($this->apiRequestTransferMock));
    }
}
