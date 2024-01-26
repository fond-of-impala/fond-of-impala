<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\Zed\CollaborativeCartsRestApiStubInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CollaborativeCartsRestApiClientTest extends Unit
{
    protected MockObject|CollaborativeCartsRestApiFactory $collaborativeCartsRestApiFactoryMock;

    protected MockObject|CollaborativeCartsRestApiStubInterface $collaborativeCartsRestApiStubMock;

    protected MockObject|RestClaimCartRequestTransfer $restClaimCartRequestTransferMock;

    protected MockObject|RestClaimCartResponseTransfer $restClaimCartResponseTransferMock;

    protected MockObject|RestReleaseCartRequestTransfer $restReleaseCartRequestTransferMock;

    protected MockObject|RestReleaseCartResponseTransfer $restReleaseCartResponseTransferMock;

    protected CollaborativeCartsRestApiClient $collaborativeCartsRestApiClient;

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
