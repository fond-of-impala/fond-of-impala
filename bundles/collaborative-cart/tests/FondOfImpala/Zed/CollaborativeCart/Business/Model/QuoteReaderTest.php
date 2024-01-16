<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;

class QuoteReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ClaimCartRequestTransfer
     */
    protected $claimCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $releaseCartRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface
     */
    protected $quoteFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteResponseTransfer
     */
    protected $quoteResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReader
     */
    protected $quoteReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->claimCartRequestTransferMock = $this->getMockBuilder(ClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->releaseCartRequestTransferMock = $this->getMockBuilder(ReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CollaborativeCartToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteReader = new QuoteReader(
            $this->quoteFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByClaimCartRequest(): void
    {
        $idQuote = 1;
        $newCustomerReference = 'DE-1';

        $this->claimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteById')
            ->with($idQuote)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getOriginalCustomerReference')
            ->willReturn(null);

        $this->claimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getNewCustomerReference')
            ->willReturn($newCustomerReference);

        self::assertEquals(
            $this->quoteTransferMock,
            $this->quoteReader->getByClaimCartRequest($this->claimCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByClaimCartRequestWithoutIdQuote(): void
    {
        $idQuote = null;

        $this->claimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteFacadeMock->expects(static::never())
            ->method('findQuoteById');

        $this->quoteResponseTransferMock->expects(static::never())
            ->method('getQuoteTransfer');

        $this->quoteResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $this->quoteTransferMock->expects(static::never())
            ->method('getOriginalCustomerReference');

        $this->claimCartRequestTransferMock->expects(static::never())
            ->method('getNewCustomerReference');

        self::assertEquals(
            null,
            $this->quoteReader->getByClaimCartRequest($this->claimCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetAlreadyClaimedByClaimCartRequest(): void
    {
        $idQuote = 1;
        $originalCustomerReference = 'DE-1';

        $this->claimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteById')
            ->with($idQuote)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getOriginalCustomerReference')
            ->willReturn($originalCustomerReference);

        $this->claimCartRequestTransferMock->expects(static::never())
            ->method('getNewCustomerReference');

        self::assertEquals(
            null,
            $this->quoteReader->getByClaimCartRequest($this->claimCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByReleaseCartRequest(): void
    {
        $idQuote = 1;
        $customerReference = 'DE-1';
        $originalCustomerReference = 'DE-2';

        $this->releaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteById')
            ->with($idQuote)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getOriginalCustomerReference')
            ->willReturn($originalCustomerReference);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->releaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomerReference')
            ->willReturn($customerReference);

        self::assertEquals(
            $this->quoteTransferMock,
            $this->quoteReader->getByReleaseCartRequest($this->releaseCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByReleaseCartRequestWithoutIdQuote(): void
    {
        $this->releaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn(null);

        $this->quoteFacadeMock->expects(static::never())
            ->method('findQuoteById');

        $this->releaseCartRequestTransferMock->expects(static::never())
            ->method('getCurrentCustomerReference');

        self::assertEquals(
            null,
            $this->quoteReader->getByReleaseCartRequest($this->releaseCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByReleaseCartRequestWithoutExistingQuote(): void
    {
        $idQuote = 1;
        $customerReference = 'DE-1';
        $originalCustomerReference = 'DE-2';

        $this->releaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteById')
            ->with($idQuote)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn(null);

        $this->quoteResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $this->releaseCartRequestTransferMock->expects(static::never())
            ->method('getCurrentCustomerReference');

        self::assertEquals(
            null,
            $this->quoteReader->getByReleaseCartRequest($this->releaseCartRequestTransferMock),
        );
    }
}
