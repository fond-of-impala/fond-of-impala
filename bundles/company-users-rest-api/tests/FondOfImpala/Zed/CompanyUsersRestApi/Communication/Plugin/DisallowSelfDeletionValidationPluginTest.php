<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacade;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DisallowSelfDeletionValidationPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersRestApiFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestDeleteCompanyUserRequestTransfer|MockObject $restDeleteCompanyUserRequestTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\DisallowSelfDeletionValidationPlugin
     */
    protected DisallowSelfDeletionValidationPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CompanyUsersRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new DisallowSelfDeletionValidationPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('canDeleteCompanyUser')
            ->willReturn(true);

        $this->plugin->validate($this->companyUserTransferMock, $this->restDeleteCompanyUserRequestTransferMock);
    }
}
