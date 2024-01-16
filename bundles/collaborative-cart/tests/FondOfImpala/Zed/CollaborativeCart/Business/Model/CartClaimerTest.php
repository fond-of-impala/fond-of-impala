<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Communication\Plugin\PermissionExtension\CollaborateCartPermissionPlugin;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToPermissionFacadeInterface;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CartClaimerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReaderInterface
     */
    protected $quoteReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteWriterInterface
     */
    protected $quoteWriterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Business\Model\CompanyUserReaderInterface
     */
    protected $companyUserReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ClaimCartRequestTransfer
     */
    protected $claimCartRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\Model\CartClaimer
     */
    protected $cartClaimer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteWriterMock = $this->getMockBuilder(QuoteWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CollaborativeCartToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartRequestTransferMock = $this->getMockBuilder(ClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartClaimer = new CartClaimer(
            $this->quoteReaderMock,
            $this->quoteWriterMock,
            $this->companyUserReaderMock,
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testClaim(): void
    {
        $idCompanyUser = 1;
        $companyUserReference = 'DE-CU-1';
        $currentCompanyUserReference = 'DE-CU-2';
        $customerReference = 'DE-CU-1';
        $currentCustomerReference = 'DE-CU-2';

        $this->quoteReaderMock->expects(self::atLeastOnce())
            ->method('getByClaimCartRequest')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->companyUserReaderMock->expects(self::atLeastOnce())
            ->method('getActiveByClaimCartRequestAndQuote')
            ->with($this->claimCartRequestTransferMock, $this->quoteTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(self::atLeastOnce())
            ->method('can')
            ->with(CollaborateCartPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($currentCompanyUserReference);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setOriginalCompanyUserReference')
            ->with($currentCompanyUserReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($currentCustomerReference);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setOriginalCustomerReference')
            ->with($currentCustomerReference)
            ->willReturn($this->quoteTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($this->quoteTransferMock);

        $this->claimCartRequestTransferMock->expects(self::atLeastOnce())
            ->method('getNewCustomerReference')
            ->willReturn($customerReference);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setCustomerReference')
            ->with($customerReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteWriterMock->expects(self::atLeastOnce())
            ->method('update')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $claimCartResponseTransfer = $this->cartClaimer->claim($this->claimCartRequestTransferMock);

        self::assertTrue($claimCartResponseTransfer->getIsSuccess());
        self::assertEquals(null, $claimCartResponseTransfer->getError());
        self::assertEquals($this->quoteTransferMock, $claimCartResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testClaimWithUpdateError(): void
    {
        $idCompanyUser = 1;
        $companyUserReference = 'DE-CU-1';
        $currentCompanyUserReference = 'DE-CU-2';
        $customerReference = 'DE-CU-1';
        $currentCustomerReference = 'DE-CU-2';

        $this->quoteReaderMock->expects(self::atLeastOnce())
            ->method('getByClaimCartRequest')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->companyUserReaderMock->expects(self::atLeastOnce())
            ->method('getActiveByClaimCartRequestAndQuote')
            ->with($this->claimCartRequestTransferMock, $this->quoteTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(self::atLeastOnce())
            ->method('can')
            ->with(CollaborateCartPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($currentCompanyUserReference);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setOriginalCompanyUserReference')
            ->with($currentCompanyUserReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($currentCustomerReference);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setOriginalCustomerReference')
            ->with($currentCustomerReference)
            ->willReturn($this->quoteTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($this->quoteTransferMock);

        $this->claimCartRequestTransferMock->expects(self::atLeastOnce())
            ->method('getNewCustomerReference')
            ->willReturn($customerReference);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setCustomerReference')
            ->with($customerReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteWriterMock->expects(self::atLeastOnce())
            ->method('update')
            ->with($this->quoteTransferMock)
            ->willReturn(null);

        $claimCartResponseTransfer = $this->cartClaimer->claim($this->claimCartRequestTransferMock);

        self::assertFalse($claimCartResponseTransfer->getIsSuccess());
        self::assertNotEquals(null, $claimCartResponseTransfer->getError());
        self::assertEquals(null, $claimCartResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testClaimWithWrongPermission(): void
    {
        $idCompanyUser = 1;

        $this->quoteReaderMock->expects(self::atLeastOnce())
            ->method('getByClaimCartRequest')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->companyUserReaderMock->expects(self::atLeastOnce())
            ->method('getActiveByClaimCartRequestAndQuote')
            ->with($this->claimCartRequestTransferMock, $this->quoteTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(self::atLeastOnce())
            ->method('can')
            ->with(CollaborateCartPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(false);

        $this->quoteTransferMock->expects(self::never())
            ->method('getCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('getCustomerReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCustomerReference');

        $this->companyUserTransferMock->expects(self::never())
            ->method('getCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setCompanyUserReference');

        $this->claimCartRequestTransferMock->expects(self::never())
            ->method('getNewCustomerReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setCustomerReference');

        $this->quoteWriterMock->expects(self::never())
            ->method('update');

        $claimCartResponseTransfer = $this->cartClaimer->claim($this->claimCartRequestTransferMock);

        self::assertFalse($claimCartResponseTransfer->getIsSuccess());
        self::assertNotEquals(null, $claimCartResponseTransfer->getError());
        self::assertEquals(null, $claimCartResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testClaimWithNonExistingQuote(): void
    {
        $this->quoteReaderMock->expects(self::atLeastOnce())
            ->method('getByClaimCartRequest')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn(null);

        $this->companyUserReaderMock->expects(self::never())
            ->method('getActiveByClaimCartRequestAndQuote');

        $this->companyUserTransferMock->expects(self::never())
            ->method('getIdCompanyUser');

        $this->permissionFacadeMock->expects(self::never())
            ->method('can');

        $this->quoteTransferMock->expects(self::never())
            ->method('getCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('getCustomerReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCustomerReference');

        $this->companyUserTransferMock->expects(self::never())
            ->method('getCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setCompanyUserReference');

        $this->claimCartRequestTransferMock->expects(self::never())
            ->method('getNewCustomerReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setCustomerReference');

        $this->quoteWriterMock->expects(self::never())
            ->method('update');

        $claimCartResponseTransfer = $this->cartClaimer->claim($this->claimCartRequestTransferMock);

        self::assertFalse($claimCartResponseTransfer->getIsSuccess());
        self::assertNotEquals(null, $claimCartResponseTransfer->getError());
        self::assertEquals(null, $claimCartResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testClaimWithNonExistingCompanyUser(): void
    {
        $idCompanyUser = 1;
        $companyUserReference = 'DE-CU-1';
        $currentCompanyUserReference = 'DE-CU-2';
        $customerReference = 'DE-CU-1';
        $currentCustomerReference = 'DE-CU-2';

        $this->quoteReaderMock->expects(self::atLeastOnce())
            ->method('getByClaimCartRequest')
            ->with($this->claimCartRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->companyUserReaderMock->expects(self::atLeastOnce())
            ->method('getActiveByClaimCartRequestAndQuote')
            ->with($this->claimCartRequestTransferMock, $this->quoteTransferMock)
            ->willReturn(null);

        $this->companyUserTransferMock->expects(self::never())
            ->method('getIdCompanyUser');

        $this->permissionFacadeMock->expects(self::never())
            ->method('can');

        $this->quoteTransferMock->expects(self::never())
            ->method('getCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('getCustomerReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCustomerReference');

        $this->companyUserTransferMock->expects(self::never())
            ->method('getCompanyUserReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setCompanyUserReference');

        $this->claimCartRequestTransferMock->expects(self::never())
            ->method('getNewCustomerReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setCustomerReference');

        $this->quoteWriterMock->expects(self::never())
            ->method('update');

        $claimCartResponseTransfer = $this->cartClaimer->claim($this->claimCartRequestTransferMock);

        self::assertFalse($claimCartResponseTransfer->getIsSuccess());
        self::assertNotEquals(null, $claimCartResponseTransfer->getError());
        self::assertEquals(null, $claimCartResponseTransfer->getQuote());
    }
}
