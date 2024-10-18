<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Api\Business\ApiFacadeInterface;

class ErpOrderCancellationApiToApiFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected MockObject|ApiCollectionTransfer $apiCollectionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected MockObject|ApiItemTransfer $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Api\Business\ApiFacadeInterface
     */
    protected MockObject|ApiFacadeInterface $apiFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeBridge
     */
    protected ErpOrderCancellationApiToApiFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->abstractTransferMock = $this
            ->getMockBuilder(AbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionFacadeMock = $this
            ->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiFacadeMock = $this
            ->getMockBuilder(ApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this
            ->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ErpOrderCancellationApiToApiFacadeBridge(
            $this->apiFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateApiItem(): void
    {
        $id = '1';

        $this->apiFacadeMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->with($this->abstractTransferMock, $id)
            ->willReturn($this->apiItemTransferMock);

        $apiItemTransfer = $this->bridge->createApiItem($this->abstractTransferMock, $id);

        static::assertEquals($this->apiItemTransferMock, $apiItemTransfer);
    }

    /**
     * @return void
     */
    public function testCreateApiCollection(): void
    {
        $transfers = [
            $this->abstractTransferMock,
        ];

        $this->apiFacadeMock->expects(static::atLeastOnce())
            ->method('createApiCollection')
            ->with($transfers)
            ->willReturn($this->apiCollectionFacadeMock);

        $apiCollectionTransfer = $this->bridge->createApiCollection($transfers);

        static::assertEquals($this->apiCollectionFacadeMock, $apiCollectionTransfer);
    }
}
