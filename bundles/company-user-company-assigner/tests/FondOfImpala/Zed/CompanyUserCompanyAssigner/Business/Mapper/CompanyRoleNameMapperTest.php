<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRoleNameMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleNameFilterMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapper
     */
    protected $companyRoleNameMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleNameFilterMock = $this->getMockBuilder(CompanyRoleNameFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyUserCompanyAssignerConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleNameMapper = new CompanyRoleNameMapper(
            $this->companyRoleNameFilterMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testFromManufacturerUser(): void
    {
        $currentManufacturerRoleName = 'foo_role';
        $manufacturerCompanyTypeRoleMapping = [
            'foo_bar_role' => 'bar_foo_role',
            $currentManufacturerRoleName => 'bar_role',
        ];

        $this->companyRoleNameFilterMock->expects(static::atLeastOnce())
            ->method('filterFromCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($currentManufacturerRoleName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn($manufacturerCompanyTypeRoleMapping);

        static::assertEquals(
            $manufacturerCompanyTypeRoleMapping[$currentManufacturerRoleName],
            $this->companyRoleNameMapper->fromManufacturerUser($this->companyUserTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFromManufacturerUserWithoutManufacturerCompanyTypeRoleMapping(): void
    {
        $currentManufacturerRoleName = 'foo_role';
        $manufacturerCompanyTypeRoleMapping = [];

        $this->companyRoleNameFilterMock->expects(static::atLeastOnce())
            ->method('filterFromCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($currentManufacturerRoleName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn($manufacturerCompanyTypeRoleMapping);

        static::assertEquals(
            $currentManufacturerRoleName,
            $this->companyRoleNameMapper->fromManufacturerUser($this->companyUserTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFromManufacturerUserWithoutMappingHit(): void
    {
        $currentManufacturerRoleName = 'foo_role';
        $manufacturerCompanyTypeRoleMapping = [
            'foo_bar_role' => 'bar_foo_role',
        ];

        $this->companyRoleNameFilterMock->expects(static::atLeastOnce())
            ->method('filterFromCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($currentManufacturerRoleName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn($manufacturerCompanyTypeRoleMapping);

        static::assertEquals(
            $currentManufacturerRoleName,
            $this->companyRoleNameMapper->fromManufacturerUser($this->companyUserTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFromManufacturerUserWithoutCurrentManufacturerRoleName(): void
    {
        $currentManufacturerRoleName = null;

        $this->companyRoleNameFilterMock->expects(static::atLeastOnce())
            ->method('filterFromCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($currentManufacturerRoleName);

        $this->configMock->expects(static::never())
            ->method('getManufacturerCompanyTypeRoleMapping');

        static::assertEquals(
            null,
            $this->companyRoleNameMapper->fromManufacturerUser($this->companyUserTransferMock),
        );
    }
}
