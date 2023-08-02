<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\RestCompanyRoleTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;

class CompanyRoleCollectionReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyRoleTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyRoleTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleResponseTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReader
     */
    protected $companyRoleCollectionReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyRoleTransferMock = $this->getMockBuilder(RestCompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionReader = new CompanyRoleCollectionReader(
            $this->companyRoleFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByRestWriteCompanyUserRequest(): void
    {
        $uuid = '0f699616-eac7-45eb-832f-04d6577f9bb9';

        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getRestCompanyUsersRequestAttributes')
            ->willReturn($this->restCompanyUsersRequestAttributesTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->restCompanyRoleTransferMock);

        $this->restCompanyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuid);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->with(
                static::callback(
                    static function (CompanyRoleTransfer $companyRoleTransfer) use ($uuid) {
                        return $companyRoleTransfer->getUuid() === $uuid;
                    },
                ),
            )->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $companyRoleCollectionTransfer = $this->companyRoleCollectionReader->getByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );

        static::assertCount(1, $companyRoleCollectionTransfer->getRoles());
        static::assertEquals(
            $this->companyRoleTransferMock,
            $companyRoleCollectionTransfer->getRoles()->offsetGet(0),
        );
    }

    /**
     * @return void
     */
    public function testGetByRestWriteCompanyUserRequestWithInvalidData(): void
    {
        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getRestCompanyUsersRequestAttributes')
            ->willReturn(null);

        $this->companyRoleFacadeMock->expects(static::never())
            ->method('findCompanyRoleByUuid');

        $companyRoleCollectionTransfer = $this->companyRoleCollectionReader->getByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );

        static::assertEquals(
            null,
            $companyRoleCollectionTransfer,
        );
    }

    /**
     * @return void
     */
    public function testGetByRestWriteCompanyUserRequestWithoutRestCompanyRole(): void
    {
        $uuid = '0f699616-eac7-45eb-832f-04d6577f9bb9';

        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getRestCompanyUsersRequestAttributes')
            ->willReturn($this->restCompanyUsersRequestAttributesTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn(null);

        $this->companyRoleFacadeMock->expects(static::never())
            ->method('findCompanyRoleByUuid');

        $companyRoleCollectionTransfer = $this->companyRoleCollectionReader->getByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );

        static::assertEquals(
            null,
            $companyRoleCollectionTransfer,
        );
    }

    /**
     * @return void
     */
    public function testGetByRestWriteCompanyUserRequestWithNonExistingCompanyRole(): void
    {
        $uuid = '0f699616-eac7-45eb-832f-04d6577f9bb9';

        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getRestCompanyUsersRequestAttributes')
            ->willReturn($this->restCompanyUsersRequestAttributesTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->restCompanyRoleTransferMock);

        $this->restCompanyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuid);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->with(
                static::callback(
                    static function (CompanyRoleTransfer $companyRoleTransfer) use ($uuid) {
                        return $companyRoleTransfer->getUuid() === $uuid;
                    },
                ),
            )->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn(null);

        $this->companyRoleResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $companyRoleCollectionTransfer = $this->companyRoleCollectionReader->getByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );

        static::assertEquals(
            null,
            $companyRoleCollectionTransfer,
        );
    }
}
