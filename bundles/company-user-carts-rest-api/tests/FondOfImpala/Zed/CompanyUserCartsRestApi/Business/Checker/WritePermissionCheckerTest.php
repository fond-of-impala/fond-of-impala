<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserCartPermissionPlugin;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class WritePermissionCheckerTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserReaderInterface $companyUserReaderMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCartsRestApiToPermissionFacadeInterface|MockObject $permissionFacadeMock;

    /**
     * @var (\Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionChecker
     */
    protected WritePermissionChecker $writePermissionChecker;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->writePermissionChecker = new WritePermissionChecker(
            $this->companyUserReaderMock,
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCheckByRestCompanyUserCartsRequest(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getIdByRestCompanyUserCartsRequest')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserCartPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        static::assertTrue(
            $this->writePermissionChecker->checkByRestCompanyUserCartsRequest(
                $this->restCompanyUserCartsRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCheckByRestCompanyUserCartsRequestWithInvalidData(): void
    {
        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getIdByRestCompanyUserCartsRequest')
            ->willReturn(null);

        $this->permissionFacadeMock->expects(static::never())
            ->method('can');

        static::assertFalse(
            $this->writePermissionChecker->checkByRestCompanyUserCartsRequest(
                $this->restCompanyUserCartsRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCheckByCompanyUser(): void
    {
        $idCompanyUser = 1;

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserCartPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        static::assertTrue(
            $this->writePermissionChecker->checkByCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCheckByCompanyUserWithInvalidData(): void
    {
        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn(null);

        $this->permissionFacadeMock->expects(static::never())
            ->method('can');

        static::assertFalse(
            $this->writePermissionChecker->checkByCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCheckByIdCompanyUser(): void
    {
        $idCompanyUser = 1;

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserCartPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        static::assertTrue(
            $this->writePermissionChecker->checkByIdCompanyUser($idCompanyUser),
        );
    }
}
