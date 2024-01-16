<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Communication\Plugin\PermissionExtension\SeeAllCompanyBusinessUnitQuotesPermissionPlugin;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\CompanyBusinessUnitQuoteConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\CompanyBusinessUnitQuoteConnectorRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer
     */
    protected $companyBusinessUnitQuoteListRequestTransferMock;

    /**
     * @var int
     */
    protected $idCustomer;

    /**
     * @var int
     */
    protected $idCompanyBusinessUnit;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var int
     */
    protected $idCompanyUser;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyBusinessUnitQuoteConnectorRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListRequestTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCustomer = 1;
        $this->idCompanyBusinessUnit = 1;

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompanyUser = 1;

        $this->companyUserReader = new CompanyUserReader(
            $this->repositoryMock,
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest(): void
    {
        $companyUserReference = 'STORE--CU-1';

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($this->idCustomer);

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($this->idCompanyBusinessUnit);

        $this->repositoryMock->expects(self::atLeastOnce())
            ->method('getActiveCompanyUserByCompanyBusinessUnitQuoteListRequest')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($this->idCompanyUser);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->permissionFacadeMock->expects(self::atLeastOnce())
            ->method('can')
            ->with(SeeAllCompanyBusinessUnitQuotesPermissionPlugin::KEY, $this->idCompanyUser)
            ->willReturn(false);

        $this->repositoryMock->expects(self::never())
            ->method('getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock);

        $companyUserReferenceCollectionTransfer = $this->companyUserReader
            ->getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest(
                $this->companyBusinessUnitQuoteListRequestTransferMock,
            );

        self::assertContains(
            $companyUserReference,
            $companyUserReferenceCollectionTransfer->getCompanyUserReferences(),
        );
    }

    /**
     * @return void
     */
    public function testGetActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequestWithPermissionToSeeAllCompanyBusinessUnitQuotes(): void
    {
        $companyUserReferences = ['STORE--CU-1'];

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($this->idCustomer);

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($this->idCompanyBusinessUnit);

        $this->repositoryMock->expects(self::atLeastOnce())
            ->method('getActiveCompanyUserByCompanyBusinessUnitQuoteListRequest')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($this->idCompanyUser);

        $this->companyUserTransferMock->expects(self::never())
            ->method('getCompanyUserReference');

        $this->permissionFacadeMock->expects(self::atLeastOnce())
            ->method('can')
            ->with(SeeAllCompanyBusinessUnitQuotesPermissionPlugin::KEY, $this->idCompanyUser)
            ->willReturn(true);

        $this->repositoryMock->expects(self::atLeastOnce())
            ->method('getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($companyUserReferences);

        $companyUserReferenceCollectionTransfer = $this->companyUserReader
            ->getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest(
                $this->companyBusinessUnitQuoteListRequestTransferMock,
            );

        self::assertEquals(
            $companyUserReferences,
            $companyUserReferenceCollectionTransfer->getCompanyUserReferences(),
        );
    }

    /**
     * @return void
     */
    public function testGetActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequestWithoutCompanyUser(): void
    {
        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(null);

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::never())
            ->method('getIdCompanyBusinessUnit');

        $this->repositoryMock->expects(self::never())
            ->method('getActiveCompanyUserByCompanyBusinessUnitQuoteListRequest')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->companyUserTransferMock->expects(self::never())
            ->method('getIdCompanyUser')
            ->willReturn($this->idCompanyUser);

        $this->companyUserTransferMock->expects(self::never())
            ->method('getCompanyUserReference');

        $this->permissionFacadeMock->expects(self::never())
            ->method('can')
            ->with(SeeAllCompanyBusinessUnitQuotesPermissionPlugin::KEY, $this->idCompanyUser);

        $this->repositoryMock->expects(self::never())
            ->method('getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock);

        $companyUserReferenceCollectionTransfer = $this->companyUserReader
            ->getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest(
                $this->companyBusinessUnitQuoteListRequestTransferMock,
            );

        self::assertEmpty(
            $companyUserReferenceCollectionTransfer->getCompanyUserReferences(),
        );
    }
}
