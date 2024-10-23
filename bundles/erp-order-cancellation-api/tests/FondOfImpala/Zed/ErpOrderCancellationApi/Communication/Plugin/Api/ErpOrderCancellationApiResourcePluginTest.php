<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiFacade;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationApiResourcePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected MockObject|ApiDataTransfer $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected MockObject|ApiCollectionTransfer $apiCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected MockObject|ApiItemTransfer $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected MockObject|ApiRequestTransfer $apiRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiFacade
     */
    protected MockObject|ErpOrderCancellationApiFacade $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Communication\Plugin\Api\ErpOrderCancellationApiResourcePlugin
     */
    protected ErpOrderCancellationApiResourcePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiCollectionTransferMock = $this
            ->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this
            ->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this
            ->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this
            ->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this
            ->getMockBuilder(ErpOrderCancellationApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ErpOrderCancellationApiResourcePlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testGetResourceName(): void
    {
        static::assertIsString($this->plugin->getResourceName());
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellation')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->plugin->add($this->apiDataTransferMock);

        static::assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $id = 1;

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getErpOrderCancellation')
            ->with($id)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->plugin->get($id);

        static::assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $id = 1;

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->with($id, $this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->plugin->update($id, $this->apiDataTransferMock);

        static::assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testRemove(): void
    {
        $id = 1;

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('deleteErpOrderCancellation')
            ->with($id)
            ->willReturn($this->apiItemTransferMock);

        $responseTransfer = $this->plugin->remove($id);

        static::assertEquals($this->apiItemTransferMock, $responseTransfer);
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellations')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $responseTransfer = $this->plugin->find($this->apiRequestTransferMock);

        static::assertEquals($this->apiCollectionTransferMock, $responseTransfer);
    }
}
