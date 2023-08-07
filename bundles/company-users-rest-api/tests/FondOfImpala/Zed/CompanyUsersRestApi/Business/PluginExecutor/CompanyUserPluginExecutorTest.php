<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor;
use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface;
use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreCreatePluginInterface;
use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreDeleteValidationPluginInterface;
use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreUpdateValidationPluginInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserPluginExecutorTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreCreatePluginInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserPreCreatePluginInterface|MockObject $companyUserPreCreatePluginMock;

    /**
     * @var \FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserPostCreatePluginInterface|MockObject $companyUserPostCreatePluginMock;

    /**
     * @var \FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreDeleteValidationPluginInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserPreDeleteValidationPluginInterface|MockObject $companyUserPreDeleteValidationPluginMock;

    /**
     * @var \FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreUpdateValidationPluginInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserPreUpdateValidationPluginInterface|MockObject $companyUserPreUpdateValidationPluginMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUsersRequestAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestWriteCompanyUserRequestTransfer|MockObject $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestDeleteCompanyUserRequestTransfer|MockObject $restDeleteCompanyUserRequestTransfer;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface
     */
    protected $pluginExecutor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserPreCreatePluginMock = $this->getMockBuilder(CompanyUserPreCreatePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserPostCreatePluginMock = $this->getMockBuilder(CompanyUserPostCreatePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserPreDeleteValidationPluginMock = $this->getMockBuilder(CompanyUserPreDeleteValidationPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserPreUpdateValidationPluginMock = $this->getMockBuilder(CompanyUserPreUpdateValidationPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransfer = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pluginExecutor = new CompanyUserPluginExecutor(
            [$this->companyUserPreCreatePluginMock],
            [$this->companyUserPostCreatePluginMock],
            [$this->companyUserPreDeleteValidationPluginMock],
            [$this->companyUserPreUpdateValidationPluginMock],
        );
    }

    /**
     * @return void
     */
    public function testExecutePostCreatePlugins(): void
    {
        $this->companyUserPostCreatePluginMock->expects(static::atLeastOnce())
            ->method('postCreate')
            ->with($this->companyUserTransferMock, $this->companyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        static::assertInstanceOf(
            CompanyUserTransfer::class,
            $this->pluginExecutor->executePostCreatePlugins(
                $this->companyUserTransferMock,
                $this->companyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExecutePreCreatePlugins(): void
    {
        $this->companyUserPreCreatePluginMock->expects(static::atLeastOnce())
            ->method('preCreate')
            ->with($this->companyUserTransferMock, $this->companyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        static::assertInstanceOf(
            CompanyUserTransfer::class,
            $this->pluginExecutor->executePreCreatePlugins(
                $this->companyUserTransferMock,
                $this->companyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExecutePreUpdatePlugins(): void
    {
        $this->companyUserPreUpdateValidationPluginMock->expects(static::atLeastOnce())
            ->method('validate')
            ->with($this->companyUserTransferMock, $this->restWriteCompanyUserRequestTransferMock)
            ->willReturn(true);

        $this->pluginExecutor->executePreUpdateValidationPlugins(
            $this->companyUserTransferMock,
            $this->restWriteCompanyUserRequestTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testExecutePreDeletePlugins(): void
    {
        $this->companyUserPreDeleteValidationPluginMock->expects(static::atLeastOnce())
            ->method('validate')
            ->with($this->companyUserTransferMock, $this->restDeleteCompanyUserRequestTransfer)
            ->willReturn(true);

        $this->pluginExecutor->executePreDeleteValidationPlugins(
            $this->companyUserTransferMock,
            $this->restDeleteCompanyUserRequestTransfer,
        );
    }
}
