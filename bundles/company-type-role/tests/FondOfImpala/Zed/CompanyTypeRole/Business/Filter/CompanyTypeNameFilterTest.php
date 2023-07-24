<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Filter;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeNameFilterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyRoleTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTypeTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyTypeTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilter
     */
    protected $companyTypeNameFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeNameFilter = new CompanyTypeNameFilter($this->companyTypeFacadeMock);
    }

    /**
     * @return void
     */
    public function testFilterFromCompanyRole(): void
    {
        $fkCompanyType = 1;
        $companyTypeName = 'foo bar';

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($fkCompanyType);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyTypeById')
            ->with(
                static::callback(
                    static function (CompanyTypeTransfer $companyTypeTransfer) use ($fkCompanyType) {
                        return $companyTypeTransfer->getIdCompanyType() === $fkCompanyType;
                    },
                ),
            )->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyTypeName);

        static::assertEquals(
            $companyTypeName,
            $this->companyTypeNameFilter->filterFromCompanyRole($this->companyRoleTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromCompanyRoleWithoutCompany(): void
    {
        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->companyTransferMock->expects(static::never())
            ->method('getFkCompanyType');

        $this->companyTypeFacadeMock->expects(static::never())
            ->method('getCompanyTypeById');

        $this->companyTypeTransferMock->expects(static::never())
            ->method('getName');

        static::assertEquals(
            null,
            $this->companyTypeNameFilter->filterFromCompanyRole($this->companyRoleTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromCompanyRoleWithoutCompanyType(): void
    {
        $fkCompanyType = 1;

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($fkCompanyType);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyTypeById')
            ->with(
                static::callback(
                    static function (CompanyTypeTransfer $companyTypeTransfer) use ($fkCompanyType) {
                        return $companyTypeTransfer->getIdCompanyType() === $fkCompanyType;
                    },
                ),
            )->willReturn(null);

        $this->companyTypeTransferMock->expects(static::never())
            ->method('getName');

        static::assertEquals(
            null,
            $this->companyTypeNameFilter->filterFromCompanyRole($this->companyRoleTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromCompanyRoleWithoutCompanyTypeName(): void
    {
        $fkCompanyType = 1;

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($fkCompanyType);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyTypeById')
            ->with(
                static::callback(
                    static function (CompanyTypeTransfer $companyTypeTransfer) use ($fkCompanyType) {
                        return $companyTypeTransfer->getIdCompanyType() === $fkCompanyType;
                    },
                ),
            )->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn(null);

        static::assertEquals(
            null,
            $this->companyTypeNameFilter->filterFromCompanyRole($this->companyRoleTransferMock),
        );
    }
}
