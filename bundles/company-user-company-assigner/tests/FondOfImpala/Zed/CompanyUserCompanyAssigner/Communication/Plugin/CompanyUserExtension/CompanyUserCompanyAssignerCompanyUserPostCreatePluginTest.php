<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\CompanyUserCompanyAssignerCommunicationFactory;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserCompanyAssignerCompanyUserPostCreatePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\CompanyUserCompanyAssignerCommunicationFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $eventFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension\CompanyUserCompanyAssignerCompanyUserPostCreatePlugin
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CompanyUserCompanyAssignerCompanyUserPostCreatePlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testPostCreate(): void
    {
        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getSkipAssignmentToNonManufacturerCompanies')
            ->willReturn(null);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getEventFacade')
            ->willReturn($this->eventFacadeMock);

        $this->eventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with(
                CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT,
                $this->companyUserTransferMock,
            );

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->plugin->postCreate(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testPostCreateWithoutCompanyUser(): void
    {
        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->companyUserResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $this->factoryMock->expects(static::never())
            ->method('getEventFacade');

        $this->eventFacadeMock->expects(static::never())
            ->method('trigger');

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->plugin->postCreate(
                $this->companyUserResponseTransferMock,
            ),
        );
    }
}
