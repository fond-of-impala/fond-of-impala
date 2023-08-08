<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Api\Business\ApiFacadeInterface;

class PriceListApiToApiFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeBridge
     */
    protected $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Api\Business\ApiFacadeInterface
     */
    protected $facadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    protected $abstractTransferMock;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    private $apiItemTransferMock;

    /**
     * @var array
     */
    private $transferData;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    private $apiCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(ApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->abstractTransferMock = $this->getMockBuilder(AbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->id = '1';

        $this->transferData = [];

        $this->bridge = new PriceListApiToApiFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testCreateApiItem(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->with($this->abstractTransferMock, $this->id)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->bridge->createApiItem($this->abstractTransferMock, $this->id),
        );
    }

    /**
     * @return void
     */
    public function testCreateApiCollection(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('createApiCollection')
            ->with($this->transferData)
            ->willReturn($this->apiCollectionTransferMock);

        static::assertEquals(
            $this->apiCollectionTransferMock,
            $this->bridge->createApiCollection($this->transferData),
        );
    }
}
