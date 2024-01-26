<?php

namespace FondOfImpala\Zed\CollaborativeCart\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Communication\Plugin\PermissionExtension\CollaborateCartPermissionPlugin;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CollaborativeCartToPermissionFacadeBridgeTest extends Unit
{
    protected MockObject|PermissionFacadeInterface $permissionFacadeMock;

    protected CollaborativeCartToPermissionFacadeBridge $collaborativeCartToPermissionFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartToPermissionFacadeBridge = new CollaborativeCartToPermissionFacadeBridge(
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyUserCollection(): void
    {
        $key = CollaborateCartPermissionPlugin::KEY;
        $identifier = 1;

        $this->permissionFacadeMock->expects(self::atLeastOnce())
            ->method('can')
            ->with($key, $identifier, null)
            ->willReturn(true);

        self::assertTrue($this->collaborativeCartToPermissionFacadeBridge->can($key, $identifier));
    }
}
