<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Intersection;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionIntersectionTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\PermissionCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject>|array<\Generated\Shared\Transfer\PermissionTransfer>
     */
    protected $permissionTransferMocks;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersection
     */
    protected $permissionIntersection;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMocks = [
            $this->getMockBuilder(PermissionTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(PermissionTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->permissionIntersection = new PermissionIntersection();
    }

    /**
     * @return void
     */
    public function testIntersect(): void
    {
        $keys = ['foo'];

        $this->permissionCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getPermissions')
            ->willReturn(new ArrayObject($this->permissionTransferMocks));

        $this->permissionTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn($keys[0]);

        $this->permissionTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn('bar');

        $permissionCollectionTransfer = $this->permissionIntersection->intersect(
            $this->permissionCollectionTransferMock,
            $keys,
        );

        static::assertCount(1, $permissionCollectionTransfer->getPermissions());
        static::assertEquals($keys[0], $permissionCollectionTransfer->getPermissions()->offsetGet(0)->getKey());
    }
}
