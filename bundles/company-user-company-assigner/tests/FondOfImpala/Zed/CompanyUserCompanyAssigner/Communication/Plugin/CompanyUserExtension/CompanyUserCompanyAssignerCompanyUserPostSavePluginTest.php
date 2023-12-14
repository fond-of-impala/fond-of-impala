<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\CompanyUserCompanyAssignerCommunicationFactory;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeInterface;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserCompanyAssignerCompanyUserPostSavePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\CompanyUserCompanyAssignerCommunicationFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTypeTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $eventFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension\CompanyUserCompanyAssignerCompanyUserPostSavePlugin
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CompanyUserCompanyAssignerCompanyUserPostSavePlugin();
        $this->plugin->setFactory($this->factoryMock);
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testPostSave(): void
    {
        $companyUsers = [
            '1' => [
                'id_company_user' => 1,
            ],
        ];

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getManufacturerCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getCompanyTypeByCompany')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn(1);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'company-type',
                'company-type',
            );

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUsersWithInconsistentCompanyRolesByManufacturerUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($companyUsers);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getEventFacade')
            ->willReturn($this->eventFacadeMock);

        $this->eventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with(
                CompanyUserCompanyAssignerEvents::MANUFACTURER_COMPANY_USER_COMPANY_ROLE_UPDATE,
                $this->companyUserTransferMock,
            );

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->plugin->postSave(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testPostSaveWithoutCompanyUser(): void
    {
        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->plugin->postSave(
                $this->companyUserResponseTransferMock,
            ),
        );
    }
}
