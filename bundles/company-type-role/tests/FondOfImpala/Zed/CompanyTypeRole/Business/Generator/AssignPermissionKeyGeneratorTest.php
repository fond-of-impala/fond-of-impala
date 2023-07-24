<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Generator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyRoleTransfer;

class AssignPermissionKeyGeneratorTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CompanyRoleTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyRoleTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGenerator
     */
    protected $assignPermissionKeyGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assignPermissionKeyGenerator = new AssignPermissionKeyGenerator();
    }

    /**
     * @return void
     */
    public function testGenerateByCompanyRole(): void
    {
        $companyRoleName = 'foo_bar';

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyRoleName);

        static::assertEquals(
            sprintf(
                '%s%s%s',
                AssignPermissionKeyGenerator::KEY_PREFIX,
                'FooBar',
                AssignPermissionKeyGenerator::KEY_SUFFIX,
            ),
            $this->assignPermissionKeyGenerator->generateByCompanyRole($this->companyRoleTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGenerateByCompanyRoleWithoutNullableName(): void
    {
        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn(null);

        static::assertEquals(
            null,
            $this->assignPermissionKeyGenerator->generateByCompanyRole($this->companyRoleTransferMock),
        );
    }
}
