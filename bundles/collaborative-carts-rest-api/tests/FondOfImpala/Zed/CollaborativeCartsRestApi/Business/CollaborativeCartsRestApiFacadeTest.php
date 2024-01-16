<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimerInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaserInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;

class CollaborativeCartsRestApiFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCartsRestApi\Business\CollaborativeCartsRestApiBusinessFactory
     */
    protected $businessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimerInterface
     */
    protected $cartClaimerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestClaimCartRequestTransfer
     */
    protected $restClaimCartRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestClaimCartResponseTransfer
     */
    protected $restClaimCartResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaserInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $cartReleaserMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\CollaborativeCartsRestApiFacade
     */
    protected $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->businessFactoryMock = $this->getMockBuilder(CollaborativeCartsRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartClaimerMock = $this->getMockBuilder(CartClaimerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartRequestTransferMock = $this->getMockBuilder(RestClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartResponseTransferMock = $this->getMockBuilder(RestClaimCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartReleaserMock = $this->getMockBuilder(CartReleaserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestTransferMock = $this->getMockBuilder(RestReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartResponseTransferMock = $this->getMockBuilder(RestReleaseCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CollaborativeCartsRestApiFacade();
        $this->facade->setFactory($this->businessFactoryMock);
    }

    /**
     * @return void
     */
    public function testClaimCart(): void
    {
        $this->businessFactoryMock->expects(static::atLeastOnce())
            ->method('createCartClaimer')
            ->willReturn($this->cartClaimerMock);

        $this->cartClaimerMock->expects(static::atLeastOnce())
            ->method('claim')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->restClaimCartResponseTransferMock);

        static::assertEquals(
            $this->restClaimCartResponseTransferMock,
            $this->facade->claimCart($this->restClaimCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testReleaseCart(): void
    {
        $this->businessFactoryMock->expects(static::atLeastOnce())
            ->method('createCartReleaser')
            ->willReturn($this->cartReleaserMock);

        $this->cartReleaserMock->expects(static::atLeastOnce())
            ->method('release')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->restReleaseCartResponseTransferMock);

        static::assertEquals(
            $this->restReleaseCartResponseTransferMock,
            $this->facade->releaseCart($this->restReleaseCartRequestTransferMock),
        );
    }
}
