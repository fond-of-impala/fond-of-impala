<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepositoryInterface;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepositoryInterface
     */
    protected $collaborativeCartRepositoryMock;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $newCompanyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\Model\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->collaborativeCartRepositoryMock = $this->getMockBuilder(CollaborativeCartRepositoryInterface::class)
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

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->newCompanyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReader = new CompanyUserReader($this->collaborativeCartRepositoryMock);
    }

    /**
     * @return void
     */
    public function testGetActiveByClaimCartRequestAndQuote(): void
    {
        $newIdCustomer = 1;
        $fkCompany = 1;
        $fkCompanyBusinessUnit = 1;

        $this->claimCartRequestTransferMock->expects(self::atLeastOnce())
            ->method('getNewIdCustomer')
            ->willReturn($newIdCustomer);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($fkCompany);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getFkCompanyBusinessUnit')
            ->willReturn($fkCompanyBusinessUnit);

        $this->collaborativeCartRepositoryMock->expects(self::atLeastOnce())
            ->method('getCompanyUserCollectionByCompanyUserCriteriaFilterTransfer')
            ->with(
                self::callback(
                    static function (CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer) use ($newIdCustomer, $fkCompany, $fkCompanyBusinessUnit) {
                        return $companyUserCriteriaFilterTransfer->getIdCustomer() === $newIdCustomer
                            && $companyUserCriteriaFilterTransfer->getIdCompany() === $fkCompany
                            && $companyUserCriteriaFilterTransfer->getIdCompanyBusinessUnit() === $fkCompanyBusinessUnit
                            && $companyUserCriteriaFilterTransfer->getIsActive();
                    },
                ),
            )->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->newCompanyUserTransferMock]));

        self::assertEquals(
            $this->newCompanyUserTransferMock,
            $this->companyUserReader->getActiveByClaimCartRequestAndQuote(
                $this->claimCartRequestTransferMock,
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetActiveByClaimCartRequestAndQuoteWithoutNewIdCustomer(): void
    {
        $this->claimCartRequestTransferMock->expects(self::atLeastOnce())
            ->method('getNewIdCustomer')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::never())
            ->method('getCompanyUser');

        $this->companyUserTransferMock->expects(self::never())
            ->method('getFkCompany');

        $this->companyUserTransferMock->expects(self::never())
            ->method('getFkCompanyBusinessUnit');

        $this->collaborativeCartRepositoryMock->expects(self::never())
            ->method('getCompanyUserCollectionByCompanyUserCriteriaFilterTransfer');

        $this->companyUserCollectionTransferMock->expects(self::never())
            ->method('getCompanyUsers');

        self::assertEquals(
            null,
            $this->companyUserReader->getActiveByClaimCartRequestAndQuote(
                $this->claimCartRequestTransferMock,
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetActiveByClaimCartRequestAndQuoteWithoutCompanyUser(): void
    {
        $newIdCustomer = 1;

        $this->claimCartRequestTransferMock->expects(self::atLeastOnce())
            ->method('getNewIdCustomer')
            ->willReturn($newIdCustomer);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->companyUserTransferMock->expects(self::never())
            ->method('getFkCompany');

        $this->companyUserTransferMock->expects(self::never())
            ->method('getFkCompanyBusinessUnit');

        $this->collaborativeCartRepositoryMock->expects(self::never())
            ->method('getCompanyUserCollectionByCompanyUserCriteriaFilterTransfer');

        $this->companyUserCollectionTransferMock->expects(self::never())
            ->method('getCompanyUsers');

        self::assertEquals(
            null,
            $this->companyUserReader->getActiveByClaimCartRequestAndQuote(
                $this->claimCartRequestTransferMock,
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetActiveByClaimCartRequestAndQuoteWithoutNewCompanyUser(): void
    {
        $newIdCustomer = 1;
        $fkCompany = 1;
        $fkCompanyBusinessUnit = 1;

        $this->claimCartRequestTransferMock->expects(self::atLeastOnce())
            ->method('getNewIdCustomer')
            ->willReturn($newIdCustomer);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($fkCompany);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getFkCompanyBusinessUnit')
            ->willReturn($fkCompanyBusinessUnit);

        $this->collaborativeCartRepositoryMock->expects(self::atLeastOnce())
            ->method('getCompanyUserCollectionByCompanyUserCriteriaFilterTransfer')
            ->with(
                self::callback(
                    static function (CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer) use ($newIdCustomer, $fkCompany, $fkCompanyBusinessUnit) {
                        return $companyUserCriteriaFilterTransfer->getIdCustomer() === $newIdCustomer
                            && $companyUserCriteriaFilterTransfer->getIdCompany() === $fkCompany
                            && $companyUserCriteriaFilterTransfer->getIdCompanyBusinessUnit() === $fkCompanyBusinessUnit
                            && $companyUserCriteriaFilterTransfer->getIsActive();
                    },
                ),
            )->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject());

        self::assertEquals(
            null,
            $this->companyUserReader->getActiveByClaimCartRequestAndQuote(
                $this->claimCartRequestTransferMock,
                $this->quoteTransferMock,
            ),
        );
    }
}
