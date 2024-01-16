<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyBusinessUnitQuoteConnectorToPermissionFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeBridge
     */
    protected $companyBusinessUnitQuoteConnectorToPermissionFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteConnectorToPermissionFacadeBridge = new CompanyBusinessUnitQuoteConnectorToPermissionFacadeBridge(
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCan(): void
    {
        $permissionKey = 'FooPermissionPlugin';
        $identifier = 'identifier';

        $this->permissionFacadeMock->expects(self::atLeastOnce())
            ->method('can')
            ->with($permissionKey, $identifier, null)
            ->willReturn(true);

        self::assertTrue($this->companyBusinessUnitQuoteConnectorToPermissionFacadeBridge->can(
            $permissionKey,
            $identifier,
        ));
    }
}
