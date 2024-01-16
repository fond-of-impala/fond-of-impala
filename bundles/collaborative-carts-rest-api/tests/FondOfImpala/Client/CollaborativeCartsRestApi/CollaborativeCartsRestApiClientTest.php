<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\Zed\CollaborativeCartsRestApiStubInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;

class CollaborativeCartsRestApiClientTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiFactory
     */
    protected $collaborativeCartsRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CollaborativeCartsRestApi\Zed\CollaborativeCartsRestApiStubInterface
     */
    protected $collaborativeCartsRestApiStubMock;

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
     * @var \FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClient
     */
    protected $collaborativeCartsRestApiClient;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->collaborativeCartsRestApiFactoryMock = $this->getMockBuilder(CollaborativeCartsRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsRestApiStubMock = $this->getMockBuilder(CollaborativeCartsRestApiStubInterface::class)
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

        $this->collaborativeCartsRestApiClient = new CollaborativeCartsRestApiClient();
        $this->collaborativeCartsRestApiClient->setFactory($this->collaborativeCartsRestApiFactoryMock);
    }

    /**
     * @return void
     */
    public function testClaimCart(): void
    {
        $this->collaborativeCartsRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createCollaborativeCartsRestApiStub')
            ->willReturn($this->collaborativeCartsRestApiStubMock);

        $this->collaborativeCartsRestApiStubMock->expects(static::atLeastOnce())
            ->method('claimCart')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->restClaimCartResponseTransferMock);

        $claimCartResponseTransfer = $this->collaborativeCartsRestApiClient
            ->claimCart($this->restClaimCartRequestTransferMock);

        $this->assertEquals(
            $this->restClaimCartResponseTransferMock,
            $claimCartResponseTransfer,
        );
    }

    /**
     * @return void
     */
    public function testReleaseCart(): void
    {
        $this->collaborativeCartsRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createCollaborativeCartsRestApiStub')
            ->willReturn($this->collaborativeCartsRestApiStubMock);

        $this->collaborativeCartsRestApiStubMock->expects(static::atLeastOnce())
            ->method('releaseCart')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->restReleaseCartResponseTransferMock);

        $releaseCartResponseTransfer = $this->collaborativeCartsRestApiClient
            ->releaseCart($this->restReleaseCartRequestTransferMock);

        $this->assertEquals(
            $this->restReleaseCartResponseTransferMock,
            $releaseCartResponseTransfer,
        );
    }
}
