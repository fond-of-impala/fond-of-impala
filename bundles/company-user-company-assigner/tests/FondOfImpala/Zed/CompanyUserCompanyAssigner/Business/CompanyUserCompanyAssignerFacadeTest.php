<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssigner;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager\CompanyRoleManagerInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyTypeReader;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReaderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserCompanyAssignerFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerBusinessFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface
     */
    protected $companyUserMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssigner|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $manufacturerUserAssignerMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager\CompanyRoleManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleManagerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyTypeReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeReaderMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTypeTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeTransferMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade
     */
    protected $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserMock = $this->getMockBuilder(CompanyUserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manufacturerUserAssignerMock = $this->getMockBuilder(ManufacturerUserAssigner::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeReaderMock = $this->getMockBuilder(CompanyTypeReader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleManagerMock = $this->getMockBuilder(CompanyRoleManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyUserCompanyAssignerFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompanies(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUser')
            ->willReturn($this->companyUserMock);

        $this->companyUserMock->expects(static::atLeastOnce())
            ->method('addManufacturerUserToCompanies')
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->facade->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerToCompany(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUser')
            ->willReturn($this->companyUserMock);

        $this->companyUserMock->expects(static::atLeastOnce())
            ->method('addManufacturerUsersToCompany')
            ->willReturn($this->companyResponseTransferMock);

        static::assertEquals(
            $this->companyResponseTransferMock,
            $this->facade->addManufacturerUsersToCompany(
                $this->companyResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUsersToCompanyBusinessUnit(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUser')
            ->willReturn($this->companyUserMock);

        $this->companyUserMock->expects(static::atLeastOnce())
            ->method('addManufacturerUsersToCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        static::assertEquals(
            $this->companyBusinessUnitTransferMock,
            $this->facade->addManufacturerUsersToCompanyBusinessUnit(
                $this->companyBusinessUnitTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAssignManufacturerUserNonManufacturerCompanies(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createManufacturerUserAssigner')
            ->willReturn($this->manufacturerUserAssignerMock);

        $this->manufacturerUserAssignerMock->expects(static::atLeastOnce())
            ->method('assignToNonManufacturerCompanies')
            ->with($this->companyUserTransferMock);

        $this->facade->assignManufacturerUserNonManufacturerCompanies(
            $this->companyUserTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyRolesOfNonManufacturerUsers(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyRoleManager')
            ->willReturn($this->companyRoleManagerMock);

        $this->companyRoleManagerMock->expects(static::atLeastOnce())
            ->method('updateCompanyRolesOfNonManufacturerUsers');

        $this->facade->updateCompanyRolesOfNonManufacturerUsers($this->companyUserTransferMock);
    }

    /**
     * @return void
     */
    public function testGetManufacturerCompanyType(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyTypeReader')
            ->willReturn($this->companyTypeReaderMock);

        $this->companyTypeReaderMock->expects(static::atLeastOnce())
            ->method('getManufacturerCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        static::assertEquals(
            $this->companyTypeTransferMock,
            $this->facade->getManufacturerCompanyType(),
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeByCompany(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyTypeReader')
            ->willReturn($this->companyTypeReaderMock);

        $this->companyTypeReaderMock->expects(static::atLeastOnce())
            ->method('getByCompany')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        static::assertEquals(
            $this->companyTypeTransferMock,
            $this->facade->getCompanyTypeByCompany($this->companyTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUsersWithInconsistentCompanyRolesByManufacturerUser(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserReader')
            ->willReturn($this->companyUserReaderMock);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('findWithInconsistentCompanyRolesByManufacturerUser')
            ->with($this->companyUserTransferMock)
            ->willReturn([]);

        static::assertIsArray(
            $this->facade->findCompanyUsersWithInconsistentCompanyRolesByManufacturerUser($this->companyUserTransferMock),
        );
    }
}
