<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;

class CollaborativeCartsRestApiStubTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CollaborativeCartsRestApi\Zed\CollaborativeCartsRestApiStub
     */
    protected $collaborativeCartsRestApiStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestClaimCartRequestTransfer
     */
    protected $restClaimCartRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestClaimCartResponseTransfer
     */
    protected $restClaimCartResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->zedRequestClientMock = $this->getMockBuilder(CollaborativeCartsRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartRequestTransferMock = $this->getMockBuilder(RestClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartResponseTransferMock = $this->getMockBuilder(RestClaimCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestTransferMock = $this->getMockBuilder(RestReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartResponseTransferMock = $this->getMockBuilder(RestReleaseCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsRestApiStub = new CollaborativeCartsRestApiStub($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testClaimCart(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/collaborative-carts-rest-api/gateway/claim-cart',
                $this->restClaimCartRequestTransferMock,
            )->willReturn($this->restClaimCartResponseTransferMock);

        $restClaimCartResponseTransfer = $this->collaborativeCartsRestApiStub
            ->claimCart($this->restClaimCartRequestTransferMock);

        $this->assertEquals(
            $this->restClaimCartResponseTransferMock,
            $restClaimCartResponseTransfer,
        );
    }

    /**
     * @return void
     */
    public function testReleaseCart(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/collaborative-carts-rest-api/gateway/release-cart',
                $this->restReleaseCartRequestTransferMock,
            )->willReturn($this->restReleaseCartResponseTransferMock);

        $restReleaseCartResponseTransfer = $this->collaborativeCartsRestApiStub
            ->releaseCart($this->restReleaseCartRequestTransferMock);

        $this->assertEquals(
            $this->restReleaseCartResponseTransferMock,
            $restReleaseCartResponseTransfer,
        );
    }
}
