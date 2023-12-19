<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Generated\Shared\Transfer\CompanyUserTransfer;

class AssignManufacturerUserToNonManufacturerCompaniesListenerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener\AssignManufacturerUserToNonManufacturerCompaniesListener
     */
    protected $listener;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->listener = new AssignManufacturerUserToNonManufacturerCompaniesListener();
        $this->listener->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testHandle(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('assignManufacturerUserNonManufacturerCompanies')
            ->with($this->companyUserTransferMock);

        $this->listener->handle(
            $this->companyUserTransferMock,
            CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT,
        );
    }

    /**
     * @return void
     */
    public function testHandleWithInvalidEventName(): void
    {
        $this->facadeMock->expects(static::never())
            ->method('assignManufacturerUserNonManufacturerCompanies');

        $this->listener->handle(
            $this->companyUserTransferMock,
            'foo',
        );
    }
}
