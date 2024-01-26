<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartFacadeInterface;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\ClaimCartResponseTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\ReleaseCartResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CollaborativeCartsRestApiToCollaborativeCartFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Quote\Business\QuoteFacade
     */
    protected MockObject|QuoteFacade $collaborativeCartFacadeMock;

    protected MockObject|ClaimCartRequestTransfer $claimCartRequestTransferMock;

    protected MockObject|ClaimCartResponseTransfer $claimCartResponseTransferMock;

    protected MockObject|ReleaseCartRequestTransfer $releaseCartRequestTransferMock;

    protected MockObject|ReleaseCartResponseTransfer $releaseCartResponseTransferMock;

    protected CollaborativeCartsRestApiToCollaborativeCartFacadeBridge $collaborativeCartsRestApiToCollaborativeCartFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->collaborativeCartFacadeMock = $this->getMockBuilder(CollaborativeCartFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartRequestTransferMock = $this->getMockBuilder(ClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartResponseTransferMock = $this->getMockBuilder(ClaimCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartRequestTransferMock = $this->getMockBuilder(ReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartResponseTransferMock = $this->getMockBuilder(ReleaseCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsRestApiToCollaborativeCartFacadeBridge =
            new CollaborativeCartsRestApiToCollaborativeCartFacadeBridge($this->collaborativeCartFacadeMock);
    }

    /**
     * @return void
     */
    public function testClaimCart(): void
    {
        $this->collaborativeCartFacadeMock->expects(static::atLeastOnce())
            ->method('claimCart')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn($this->claimCartResponseTransferMock);

        static::assertEquals(
            $this->claimCartResponseTransferMock,
            $this->collaborativeCartsRestApiToCollaborativeCartFacadeBridge->claimCart($this->claimCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testReleaseCart(): void
    {
        $this->collaborativeCartFacadeMock->expects(static::atLeastOnce())
            ->method('releaseCart')
            ->with($this->releaseCartRequestTransferMock)
            ->willReturn($this->releaseCartResponseTransferMock);

        static::assertEquals(
            $this->releaseCartResponseTransferMock,
            $this->collaborativeCartsRestApiToCollaborativeCartFacadeBridge
                ->releaseCart($this->releaseCartRequestTransferMock),
        );
    }
}
