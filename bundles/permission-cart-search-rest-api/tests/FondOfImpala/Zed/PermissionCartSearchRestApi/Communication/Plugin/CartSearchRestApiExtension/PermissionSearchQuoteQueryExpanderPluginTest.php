<?php

namespace FondOfImpala\Zed\PermissionCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\PermissionCartSearchRestApi\Communication\Plugin\PermissionExtension\SearchCartPermissionPlugin;
use FondOfImpala\Zed\PermissionCartSearchRestApi\Persistence\PermissionCartSearchRestApiRepository;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToCompanyUserTableMap;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToPermissionTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use PHPUnit\Framework\MockObject\MockObject;
use Propel\Runtime\ActiveQuery\Criteria;

class PermissionSearchQuoteQueryExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PermissionCartSearchRestApi\Persistence\PermissionCartSearchRestApiRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PermissionCartSearchRestApiRepository $repositoryMock;

    /**
     * @var array<\Generated\Shared\Transfer\FilterFieldTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $filterFieldTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\QueryJoinCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QueryJoinCollectionTransfer $queryJoinCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\PermissionCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension\PermissionSearchQuoteQueryExpanderPlugin
     */
    protected PermissionSearchQuoteQueryExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(PermissionCartSearchRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filterFieldTransferMocks = [
            $this->getMockBuilder(FilterFieldTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(FilterFieldTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->queryJoinCollectionTransferMock = $this->getMockBuilder(QueryJoinCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new PermissionSearchQuoteQueryExpanderPlugin();
        $this->plugin->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        static::assertTrue($this->plugin->isApplicable($this->filterFieldTransferMocks));
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $self = $this;

        $idPermission = 1;

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getIdPermissionByKey')
            ->with(SearchCartPermissionPlugin::KEY)
            ->willReturn($idPermission);

        $callCount = $this->atLeastOnce();
        $this->queryJoinCollectionTransferMock->expects($callCount)
            ->method('addQueryJoin')
            ->willReturnCallback(static function (QueryJoinTransfer $queryJoinTransfer) use ($self, $callCount) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertEquals([SpyQuoteTableMap::COL_COMPANY_USER_REFERENCE], $queryJoinTransfer->getLeft());
                        $self->assertEquals([SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE], $queryJoinTransfer->getRight());
                        $self->assertEquals(Criteria::INNER_JOIN, $queryJoinTransfer->getJoinType());
                        $self->assertEquals(0, $queryJoinTransfer->getWhereConditions()->count());

                        return $self->queryJoinCollectionTransferMock;
                    case 2:
                        $self->assertEquals([SpyCompanyUserTableMap::COL_ID_COMPANY_USER], $queryJoinTransfer->getLeft());
                        $self->assertEquals([SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER], $queryJoinTransfer->getRight());
                        $self->assertEquals(Criteria::INNER_JOIN, $queryJoinTransfer->getJoinType());
                        $self->assertEquals(0, $queryJoinTransfer->getWhereConditions()->count());

                        return $self->queryJoinCollectionTransferMock;
                    case 3:
                        $self->assertEquals([SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_ROLE], $queryJoinTransfer->getLeft());
                        $self->assertEquals([SpyCompanyRoleToPermissionTableMap::COL_FK_COMPANY_ROLE], $queryJoinTransfer->getRight());
                        $self->assertEquals(Criteria::INNER_JOIN, $queryJoinTransfer->getJoinType());
                        $self->assertEquals(1, $queryJoinTransfer->getWhereConditions()->count());

                        return $self->queryJoinCollectionTransferMock;
                }

                throw new Exception('Unexpected call count');
            });

        static::assertEquals(
            $this->queryJoinCollectionTransferMock,
            $this->plugin->expand(
                $this->filterFieldTransferMocks,
                $this->queryJoinCollectionTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithNonExistingPermission(): void
    {
        $idPermission = null;

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getIdPermissionByKey')
            ->with(SearchCartPermissionPlugin::KEY)
            ->willReturn($idPermission);

        $this->queryJoinCollectionTransferMock->expects(static::never())
            ->method('addQueryJoin');

        static::assertEquals(
            $this->queryJoinCollectionTransferMock,
            $this->plugin->expand(
                $this->filterFieldTransferMocks,
                $this->queryJoinCollectionTransferMock,
            ),
        );
    }
}
