<?php

namespace FondOfImpala\Zed\CompanyPriceList\Communication\Plugin\PriceListExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyPriceList\CompanyPriceListConstants;
use FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListFacade;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\PriceList\Persistence\Map\FoiPriceListTableMap;
use PHPUnit\Framework\MockObject\MockObject;
use Propel\Runtime\ActiveQuery\Criteria;

class CompanySearchPriceListQueryExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyPriceList\Communication\Plugin\PriceListExtension\CompanySearchPriceListQueryExpanderPlugin
     */
    protected CompanySearchPriceListQueryExpanderPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected MockObject|CompanyTransfer $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\FilterFieldTransfer
     */
    protected MockObject|FilterFieldTransfer $filterFieldTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    protected MockObject|QueryJoinCollectionTransfer $queryJoinCollectionTransfer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListFacade
     */
    protected MockObject|CompanyPriceListFacade $companyPriceListFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filterFieldTransferMock = $this->getMockBuilder(FilterFieldTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryJoinCollectionTransfer = $this->getMockBuilder(QueryJoinCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyPriceListFacadeMock = $this->getMockBuilder(CompanyPriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CompanySearchPriceListQueryExpanderPlugin();
        $this->plugin->setFacade($this->companyPriceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testIsApplicableWillReturnFalse(): void
    {
        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn('');

        static::assertFalse(
            $this->plugin->isApplicable(
                [$this->filterFieldTransferMock],
            ),
        );
    }

    /**
     * @return void
     */
    public function testIsApplicableWillReturnTrue(): void
    {
        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyPriceListConstants::FILTER_FIELD_TYPE_ID_CUSTOMER);

        static::assertTrue(
            $this->plugin->isApplicable(
                [$this->filterFieldTransferMock],
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWillDoNothing(): void
    {
        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn('');

        $this->plugin->expand(
            [$this->filterFieldTransferMock],
            $this->queryJoinCollectionTransfer,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $self = $this;

        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyPriceListConstants::FILTER_FIELD_TYPE_ID_CUSTOMER);

        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn('value');

        $this->queryJoinCollectionTransfer->expects(static::atLeastOnce())
            ->method('addQueryJoin')
            ->willReturnCallback(static function (QueryJoinTransfer $queryJoinTransfer) use ($self): MockObject|QueryJoinCollectionTransfer {
                static::assertSame($queryJoinTransfer->getWhereConditions()[0]->getValue(), 'value');
                static::assertSame($queryJoinTransfer->getWhereConditions()[0]->getColumn(), SpyCompanyTableMap::COL_UUID);
                static::assertSame($queryJoinTransfer->getWhereConditions()[0]->getComparison(), Criteria::EQUAL);

                static::assertSame($queryJoinTransfer->getJoinType(), Criteria::INNER_JOIN);
                static::assertSame($queryJoinTransfer->getLeft(), [FoiPriceListTableMap::COL_ID_PRICE_LIST]);
                static::assertSame($queryJoinTransfer->getRight(), [SpyCompanyTableMap::COL_FK_PRICE_LIST]);

                return $self->queryJoinCollectionTransfer;
            });

        $this->plugin->expand(
            [$this->filterFieldTransferMock],
            $this->queryJoinCollectionTransfer,
        );
    }
}
