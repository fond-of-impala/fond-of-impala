<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimerInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaserInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CollaborativeCartsRestApiFacadeTest extends Unit
{
    protected MockObject|CollaborativeCartsRestApiBusinessFactory $businessFactoryMock;

    protected MockObject|CartClaimerInterface $cartClaimerMock;

    protected MockObject|RestClaimCartRequestTransfer $restClaimCartRequestTransferMock;

    protected MockObject|RestClaimCartResponseTransfer $restClaimCartResponseTransferMock;

    protected MockObject|CartReleaserInterface $cartReleaserMock;

    protected MockObject|RestReleaseCartRequestTransfer $restReleaseCartRequestTransferMock;

    protected MockObject|RestReleaseCartResponseTransfer $restReleaseCartResponseTransferMock;

    protected CollaborativeCartsRestApiFacade $facade;

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
