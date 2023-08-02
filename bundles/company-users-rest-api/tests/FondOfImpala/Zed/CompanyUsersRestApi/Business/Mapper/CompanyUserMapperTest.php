<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class CompanyUserMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapper
     */
    protected $companyUserMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserMapper = new CompanyUserMapper();
    }

    /**
     * @return void
     */
    public function testMapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer(): void
    {
        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getIsActive')
            ->willReturn(true);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setIsActive')
            ->willReturn($this->companyUserTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getIsDefault')
            ->willReturn(true);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setIsDefault')
            ->willReturn($this->companyUserTransferMock);

        static::assertEquals(
            $this->companyUserTransferMock,
            $this->companyUserMapper->mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer(
                $this->restCompanyUsersRequestAttributesTransferMock,
                $this->companyUserTransferMock,
            ),
        );
    }
}
