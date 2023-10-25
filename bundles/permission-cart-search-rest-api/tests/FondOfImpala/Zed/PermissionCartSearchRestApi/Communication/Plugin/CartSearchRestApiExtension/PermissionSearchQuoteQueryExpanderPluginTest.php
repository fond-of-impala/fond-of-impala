<?php

namespace FondOfImpala\Zed\PermissionCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension;

use Codeception\Test\Unit;
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
        $idPermission = 1;

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getIdPermissionByKey')
            ->with(SearchCartPermissionPlugin::KEY)
            ->willReturn($idPermission);

        $this->queryJoinCollectionTransferMock->expects(static::atLeastOnce())
            ->method('addQueryJoin')
            ->withConsecutive(
                [
                    static::callback(
                        static function (QueryJoinTransfer $queryJoinTransfer) {
                            return $queryJoinTransfer->getLeft() == [SpyQuoteTableMap::COL_COMPANY_USER_REFERENCE]
                                && $queryJoinTransfer->getRight() == [SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE]
                                && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                                && $queryJoinTransfer->getWhereConditions()->count() === 0;
                        },
                    ),
                ],
                [
                    static::callback(
                        static function (QueryJoinTransfer $queryJoinTransfer) {
                            return $queryJoinTransfer->getLeft() == [SpyCompanyUserTableMap::COL_ID_COMPANY_USER]
                                && $queryJoinTransfer->getRight() == [SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER]
                                && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                                && $queryJoinTransfer->getWhereConditions()->count() === 0;
                        },
                    ),
                ],
                [
                    static::callback(
                        static function (QueryJoinTransfer $queryJoinTransfer) {
                            return $queryJoinTransfer->getLeft() == [SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_ROLE]
                                && $queryJoinTransfer->getRight() == [SpyCompanyRoleToPermissionTableMap::COL_FK_COMPANY_ROLE]
                                && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                                && $queryJoinTransfer->getWhereConditions()->count() === 1;
                        },
                    ),
                ],
            )->willReturn($this->queryJoinCollectionTransferMock);

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
