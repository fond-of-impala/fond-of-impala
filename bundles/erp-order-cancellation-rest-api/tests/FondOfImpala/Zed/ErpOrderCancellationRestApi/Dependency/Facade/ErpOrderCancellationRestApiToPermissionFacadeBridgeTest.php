<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class ErpOrderCancellationRestApiToPermissionFacadeBridgeTest extends Unit
{
    protected ErpOrderCancellationRestApiToPermissionFacadeBridge $bridge;

    protected MockObject|PermissionFacadeInterface $permissionFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->permissionFacadeMock = $this
            ->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ErpOrderCancellationRestApiToPermissionFacadeBridge(
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCan(): void
    {
        $permissionKey = 'permissionKey';
        $identifier = 'identifier';

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with($permissionKey, $identifier)
            ->willReturn(true);

        static::assertTrue($this->bridge->can($permissionKey, $identifier));
    }
}
