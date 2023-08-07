<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacade;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class LastAvailableRoleProtectionOnUpdateValidationPluginTest extends Unit
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
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestWriteCompanyUserRequestTransfer|MockObject $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\LastAvailableRoleProtectionOnUpdateValidationPlugin
     */
    protected LastAvailableRoleProtectionOnUpdateValidationPlugin $plugin;

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

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new LastAvailableRoleProtectionOnUpdateValidationPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('canUpdateCompanyUser')
            ->willReturn(true);

        $this->plugin->validate($this->companyUserTransferMock, $this->restWriteCompanyUserRequestTransferMock);
    }
}
