<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin\PermissionExtension\ReadCompanyUserCartPermissionPlugin;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ReadPermissionCheckerTest extends Unit
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
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionChecker
     */
    protected ReadPermissionChecker $readPermissionChecker;

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

        $this->readPermissionChecker = new ReadPermissionChecker(
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
            ->with(ReadCompanyUserCartPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        static::assertTrue(
            $this->readPermissionChecker->checkByRestCompanyUserCartsRequest(
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
            $this->readPermissionChecker->checkByRestCompanyUserCartsRequest(
                $this->restCompanyUserCartsRequestTransferMock,
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
            ->with(ReadCompanyUserCartPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        static::assertTrue(
            $this->readPermissionChecker->checkByIdCompanyUser($idCompanyUser),
        );
    }
}
