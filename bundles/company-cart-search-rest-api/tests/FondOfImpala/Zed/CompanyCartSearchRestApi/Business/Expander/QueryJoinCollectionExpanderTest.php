<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReaderInterface;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use PHPUnit\Framework\MockObject\MockObject;
use Propel\Runtime\ActiveQuery\Criteria;

class QueryJoinCollectionExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyReaderInterface $companyReaderMock;

    /**
     * @var array<\Generated\Shared\Transfer\FilterFieldTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $filterFieldTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\QueryJoinCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QueryJoinCollectionTransfer $queryJoinCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander\QueryJoinCollectionExpander
     */
    protected QueryJoinCollectionExpander $queryJoinCollectionExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyReaderMock = $this->getMockBuilder(CompanyReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filterFieldTransferMocks = [
            $this->getMockBuilder(FilterFieldTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->queryJoinCollectionTransferMock = $this->getMockBuilder(QueryJoinCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryJoinCollectionExpander = new QueryJoinCollectionExpander(
            $this->companyReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $self = $this;
        $idCompany = 1;

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getIdByFilterFields')
            ->with($this->filterFieldTransferMocks)
            ->willReturn($idCompany);

        $this->queryJoinCollectionTransferMock->expects($this->atLeastOnce())
            ->method('addQueryJoin')
            ->willReturnCallback(static function (QueryJoinTransfer $queryJoinTransfer) use ($self) {
                if (
                    $queryJoinTransfer->getLeft() == [SpyQuoteTableMap::COL_COMPANY_USER_REFERENCE]
                    && $queryJoinTransfer->getRight() == [SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE]
                    && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                    && $queryJoinTransfer->getWhereConditions()->count() === 1
                ) {
                    return $self->queryJoinCollectionTransferMock;
                }

                if (
                    $queryJoinTransfer->getLeft() == [SpyCompanyUserTableMap::COL_FK_CUSTOMER]
                    && $queryJoinTransfer->getRight() == [SpyCustomerTableMap::COL_ID_CUSTOMER]
                    && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                    && $queryJoinTransfer->getWhereConditions()->count() === 1
                ) {
                    return $self->queryJoinCollectionTransferMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertEquals(
            $this->queryJoinCollectionTransferMock,
            $this->queryJoinCollectionExpander->expand(
                $this->filterFieldTransferMocks,
                $this->queryJoinCollectionTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithNullableIdCompany(): void
    {
        $self = $this;

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getIdByFilterFields')
            ->with($this->filterFieldTransferMocks)
            ->willReturn(null);

        $this->queryJoinCollectionTransferMock->expects($this->atLeastOnce())
            ->method('addQueryJoin')
            ->willReturnCallback(static function (QueryJoinTransfer $queryJoinTransfer) use ($self) {
                if (
                    $queryJoinTransfer->getLeft() == [SpyQuoteTableMap::COL_COMPANY_USER_REFERENCE]
                    && $queryJoinTransfer->getRight() == [SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE]
                    && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                    && $queryJoinTransfer->getWhereConditions()->count() === 1
                ) {
                    return $self->queryJoinCollectionTransferMock;
                }

                if (
                    $queryJoinTransfer->getLeft() == [SpyCompanyUserTableMap::COL_FK_CUSTOMER]
                    && $queryJoinTransfer->getRight() == [SpyCustomerTableMap::COL_ID_CUSTOMER]
                    && $queryJoinTransfer->getJoinType() === Criteria::INNER_JOIN
                    && $queryJoinTransfer->getWhereConditions()->count() === 1
                ) {
                    return $self->queryJoinCollectionTransferMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertEquals(
            $this->queryJoinCollectionTransferMock,
            $this->queryJoinCollectionExpander->expand(
                $this->filterFieldTransferMocks,
                $this->queryJoinCollectionTransferMock,
            ),
        );
    }
}
