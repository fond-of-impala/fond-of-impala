<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyUserCartsRestApiToPermissionFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Permission\Business\PermissionFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|PermissionFacadeInterface $permissionFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeBridge
     */
    protected CompanyUserCartsRestApiToPermissionFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyUserCartsRestApiToPermissionFacadeBridge(
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCan(): void
    {
        $permissionKey = 'foo';
        $identifier = 'bar';
        $context = null;

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with($permissionKey, $identifier, $context)
            ->willReturn(true);

        static::assertTrue(
            $this->bridge->can($permissionKey, $identifier, $context),
        );
    }
}
