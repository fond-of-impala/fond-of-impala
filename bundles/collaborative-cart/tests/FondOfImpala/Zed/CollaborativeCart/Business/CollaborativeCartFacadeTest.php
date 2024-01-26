<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\CartClaimerInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteExpanderInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Releaser\CartReleaserInterface;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\ClaimCartResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\ReleaseCartResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CollaborativeCartFacadeTest extends Unit
{
    protected MockObject|CollaborativeCartBusinessFactory $collaborativeCartBusinessFactoryMock;

    protected MockObject|CartClaimerInterface $cartClaimerMock;

    protected MockObject|ClaimCartRequestTransfer $claimCartRequestTransferMock;

    protected MockObject|ClaimCartResponseTransfer $claimCartResponseTransferMock;

    protected MockObject|CartReleaserInterface $cartReleaserMock;

    protected MockObject|ReleaseCartRequestTransfer $releaseCartRequestTransferMock;

    protected MockObject|ReleaseCartResponseTransfer $releaseCartResponseTransferMock;

    protected MockObject|QuoteExpanderInterface $quoteExpanderMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected CollaborativeCartFacade $collaborativeCartFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->collaborativeCartBusinessFactoryMock = $this->getMockBuilder(CollaborativeCartBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartClaimerMock = $this->getMockBuilder(CartClaimerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartRequestTransferMock = $this->getMockBuilder(ClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartResponseTransferMock = $this->getMockBuilder(ClaimCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartReleaserMock = $this->getMockBuilder(CartReleaserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartRequestTransferMock = $this->getMockBuilder(ReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartResponseTransferMock = $this->getMockBuilder(ReleaseCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteExpanderMock = $this->getMockBuilder(QuoteExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartFacade = new CollaborativeCartFacade();
        $this->collaborativeCartFacade->setFactory($this->collaborativeCartBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testClaimCart(): void
    {
        $this->collaborativeCartBusinessFactoryMock->expects(self::atLeastOnce())
            ->method('createCartClaimer')
            ->willReturn($this->cartClaimerMock);

        $this->cartClaimerMock->expects(self::atLeastOnce())
            ->method('claim')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn($this->claimCartResponseTransferMock);

        self::assertEquals(
            $this->claimCartResponseTransferMock,
            $this->collaborativeCartFacade->claimCart($this->claimCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testReleaseCart(): void
    {
        $this->collaborativeCartBusinessFactoryMock->expects(self::atLeastOnce())
            ->method('createCartReleaser')
            ->willReturn($this->cartReleaserMock);

        $this->cartReleaserMock->expects(self::atLeastOnce())
            ->method('release')
            ->with($this->releaseCartRequestTransferMock)
            ->willReturn($this->releaseCartResponseTransferMock);

        self::assertEquals(
            $this->releaseCartResponseTransferMock,
            $this->collaborativeCartFacade->releaseCart($this->releaseCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandQuote(): void
    {
        $this->collaborativeCartBusinessFactoryMock->expects(self::atLeastOnce())
            ->method('createQuoteExpander')
            ->willReturn($this->quoteExpanderMock);

        $this->quoteExpanderMock->expects(self::atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        self::assertEquals(
            $this->quoteTransferMock,
            $this->collaborativeCartFacade->expandQuote($this->quoteTransferMock),
        );
    }
}
