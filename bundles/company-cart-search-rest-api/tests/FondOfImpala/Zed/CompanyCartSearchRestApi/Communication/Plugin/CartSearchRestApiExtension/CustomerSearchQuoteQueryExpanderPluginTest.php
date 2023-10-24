<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\PermissionExtension\SearchCartPermissionPlugin;
use FondOfImpala\Zed\CompanyCartSearchRestApi\CompanyCartSearchRestApiConfig;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepository;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToCompanyUserTableMap;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToPermissionTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use PHPUnit\Framework\MockObject\MockObject;
use Propel\Runtime\ActiveQuery\Criteria;

class CustomerSearchQuoteQueryExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\CompanyCartSearchRestApiConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCartSearchRestApiConfig $configMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCartSearchRestApiRepository $repositoryMock;

    /**
     * @var array<\Generated\Shared\Transfer\FilterFieldTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $filterFieldTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\QueryJoinCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QueryJoinCollectionTransfer $queryJoinCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension\CustomerSearchQuoteQueryExpanderPlugin
     */
    protected CustomerSearchQuoteQueryExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(CompanyCartSearchRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyCartSearchRestApiRepository::class)
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

        $this->plugin = new CustomerSearchQuoteQueryExpanderPlugin();
        $this->plugin->setConfig($this->configMock);
        $this->plugin->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $notAllowedFilterFieldTypes = [
            CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_COMPANY_UUID
        ];

        $this->configMock->expects(static::atLeastOnce())
            ->method('getNotAllowedFilterFieldTypesForCustomerFilter')
            ->willReturn($notAllowedFilterFieldTypes);

        $this->filterFieldTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn('foo');

        $this->filterFieldTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER);

        static::assertTrue($this->plugin->isApplicable($this->filterFieldTransferMocks));
    }

    /**
     * @return void
     */
    public function testIsApplicableWithInvalidFilterFieldTypes(): void
    {
        $notAllowedFilterFieldTypes = [
            CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_COMPANY_UUID
        ];

        $this->configMock->expects(static::atLeastOnce())
            ->method('getNotAllowedFilterFieldTypesForCustomerFilter')
            ->willReturn($notAllowedFilterFieldTypes);

        $this->filterFieldTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER);

        $this->filterFieldTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn($notAllowedFilterFieldTypes[0]);

        static::assertFalse($this->plugin->isApplicable($this->filterFieldTransferMocks));
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $idPermission = 1;

        $this->filterFieldTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn('foo');

        $this->filterFieldTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER);

        $this->filterFieldTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn(1);

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
                            return $queryJoinTransfer->getLeft() == [SpyCompanyUserTableMap::COL_FK_CUSTOMER]
                                && $queryJoinTransfer->getRight() == [SpyCustomerTableMap::COL_ID_CUSTOMER]
                                && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                                && $queryJoinTransfer->getWhereConditions()->count() === 1;
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
}
