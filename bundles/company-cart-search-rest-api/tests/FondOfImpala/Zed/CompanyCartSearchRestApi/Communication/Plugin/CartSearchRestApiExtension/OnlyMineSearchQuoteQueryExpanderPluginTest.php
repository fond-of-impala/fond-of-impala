<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use PHPUnit\Framework\MockObject\MockObject;
use Propel\Runtime\ActiveQuery\Criteria;

class OnlyMineSearchQuoteQueryExpanderPluginTest extends Unit
{
    /**
     * @var array<\Generated\Shared\Transfer\FilterFieldTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $filterFieldTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\QueryJoinCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QueryJoinCollectionTransfer $queryJoinCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension\OnlyMineSearchQuoteQueryExpanderPlugin
     */
    protected OnlyMineSearchQuoteQueryExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

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

        $this->plugin = new OnlyMineSearchQuoteQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $this->filterFieldTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ONLY_MINE);

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
        $this->filterFieldTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER);

        $this->filterFieldTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn('foo');

        static::assertFalse($this->plugin->isApplicable($this->filterFieldTransferMocks));
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->filterFieldTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER);

        $this->filterFieldTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn('1');

        $this->filterFieldTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ONLY_MINE);

        $this->filterFieldTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn('true');

        $this->queryJoinCollectionTransferMock->expects(static::atLeastOnce())
            ->method('addQueryJoin')
            ->withConsecutive(
                [
                    static::callback(
                        static fn (QueryJoinTransfer $queryJoinTransfer): bool => $queryJoinTransfer->getLeft() == [SpyQuoteTableMap::COL_COMPANY_USER_REFERENCE]
                            && $queryJoinTransfer->getRight() == [SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE]
                            && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                            && $queryJoinTransfer->getWhereConditions()->count() === 0,
                    ),
                ],
                [
                    static::callback(
                        static fn (QueryJoinTransfer $queryJoinTransfer): bool => $queryJoinTransfer->getLeft() == [SpyCompanyUserTableMap::COL_FK_CUSTOMER]
                            && $queryJoinTransfer->getRight() == [SpyCustomerTableMap::COL_ID_CUSTOMER]
                            && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                            && $queryJoinTransfer->getWhereConditions()->count() === 1,
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
