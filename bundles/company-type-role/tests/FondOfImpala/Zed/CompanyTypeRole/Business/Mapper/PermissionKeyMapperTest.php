<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionKeyMapperTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\PermissionCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\PermissionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\PermissionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invalidPermissionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapper
     */
    protected $permissionKeyMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->invalidPermissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionKeyMapper = new PermissionKeyMapper();
    }

    /**
     * @return void
     */
    public function testFromPermissionCollection(): void
    {
        $permissionKeys = ['foo'];

        $this->permissionCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getPermissions')
            ->willReturn(new ArrayObject([
                $this->invalidPermissionTransferMock,
                $this->permissionTransferMock,
            ]));

        $this->invalidPermissionTransferMock->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn(null);

        $this->permissionTransferMock->expects(static::atLeastOnce())
            ->method('getKey')
            ->willReturn($permissionKeys[0]);

        static::assertEquals(
            $permissionKeys,
            $this->permissionKeyMapper->fromPermissionCollection($this->permissionCollectionTransferMock),
        );
    }
}
