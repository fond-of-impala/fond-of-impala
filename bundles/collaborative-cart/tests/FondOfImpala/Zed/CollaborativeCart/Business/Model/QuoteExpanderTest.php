<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface
     */
    protected $customerFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteExpander
     */
    protected $quoteExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerFacadeMock = $this->getMockBuilder(CollaborativeCartToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFacade = $this->getMockBuilder(CollaborativeCartToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteExpander = new QuoteExpander($this->customerFacadeMock, $this->companyUserReferenceFacade);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $originalCustomerReference = 'DE-1';
        $originalCompanyUserReference = 'DE-CU-1';

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCustomer')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCustomerReference')
            ->willReturn($originalCustomerReference);

        $this->customerFacadeMock->expects(self::atLeastOnce())
            ->method('findByReference')
            ->with($originalCustomerReference)
            ->willReturn($this->customerTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setOriginalCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCompanyUser')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCompanyUserReference')
            ->willReturn($originalCompanyUserReference);

        $this->companyUserReferenceFacade->expects(self::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(self::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('setOriginalCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->quoteTransferMock);

        self::assertEquals(
            $this->quoteTransferMock,
            $this->quoteExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithInvalidReferences(): void
    {
        $originalCustomerReference = 'DE-1';
        $originalCompanyUserReference = 'DE-CU-1';

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCustomer')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCustomerReference')
            ->willReturn($originalCustomerReference);

        $this->customerFacadeMock->expects(self::atLeastOnce())
            ->method('findByReference')
            ->with($originalCustomerReference)
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCustomer');

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCompanyUser')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCompanyUserReference')
            ->willReturn($originalCompanyUserReference);

        $this->companyUserReferenceFacade->expects(self::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(self::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->companyUserResponseTransferMock->expects(self::never())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCompanyUser');

        self::assertEquals(
            $this->quoteTransferMock,
            $this->quoteExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithoutReferences(): void
    {
        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCustomer')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCustomerReference')
            ->willReturn(null);

        $this->customerFacadeMock->expects(self::never())
            ->method('findByReference');

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCustomer');

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCompanyUser')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getOriginalCompanyUserReference')
            ->willReturn(null);

        $this->companyUserReferenceFacade->expects(self::never())
            ->method('findCompanyUserByCompanyUserReference');

        $this->companyUserResponseTransferMock->expects(self::never())
            ->method('getIsSuccessful');

        $this->companyUserResponseTransferMock->expects(self::never())
            ->method('getCompanyUser');

        $this->quoteTransferMock->expects(self::never())
            ->method('setOriginalCompanyUser');

        self::assertEquals(
            $this->quoteTransferMock,
            $this->quoteExpander->expand($this->quoteTransferMock),
        );
    }
}
