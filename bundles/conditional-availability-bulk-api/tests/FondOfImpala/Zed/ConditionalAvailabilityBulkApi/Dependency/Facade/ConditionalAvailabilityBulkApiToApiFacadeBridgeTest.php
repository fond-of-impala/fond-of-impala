<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Api\Business\ApiFacadeInterface;

class ConditionalAvailabilityBulkApiToApiFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Api\Business\ApiFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected ApiFacadeInterface|MockObject $facadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Shared\Kernel\Transfer\AbstractTransfer&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected AbstractTransfer|MockObject $abstractTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ApiItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ApiItemTransfer $apiItemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToApiFacadeBridge
     */
    protected ConditionalAvailabilityBulkApiToApiFacadeBridge $bridge;

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

        $this->bridge = new ConditionalAvailabilityBulkApiToApiFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testCreateApiItem(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->with($this->abstractTransferMock, null)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->bridge->createApiItem($this->abstractTransferMock, null),
        );
    }
}
