<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepository;
use Generated\Shared\Transfer\PriceProductCriteriaTransfer;
use Generated\Shared\Transfer\QueryCriteriaTransfer;

class PriceListPriceQueryCriteriaPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension\PriceListPriceQueryCriteriaPlugin
     */
    protected $priceListPriceQueryCriteriaPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepository
     */
    protected $priceProductPriceListRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductCriteriaTransfer
     */
    protected $priceProductCriteriaTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QueryCriteriaTransfer
     */
    protected $queryCriteriaTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductPriceListRepositoryMock = $this->getMockBuilder(PriceProductPriceListRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductCriteriaTransferMock = $this->getMockBuilder(PriceProductCriteriaTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryCriteriaTransferMock = $this->getMockBuilder(QueryCriteriaTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListPriceQueryCriteriaPlugin = new PriceListPriceQueryCriteriaPlugin();
        $this->priceListPriceQueryCriteriaPlugin->setRepository($this->priceProductPriceListRepositoryMock);
    }

    /**
     * @return void
     */
    public function testBuildPriceDimensionQueryCriteria(): void
    {
        $this->priceProductPriceListRepositoryMock->expects(static::atLeastOnce())
            ->method('buildPriceListPriceDimensionCriteria')
            ->with($this->priceProductCriteriaTransferMock)
            ->willReturn($this->queryCriteriaTransferMock);

        static::assertEquals(
            $this->queryCriteriaTransferMock,
            $this->priceListPriceQueryCriteriaPlugin->buildPriceDimensionQueryCriteria(
                $this->priceProductCriteriaTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testBuildUnconditionalPriceDimensionQueryCriteria(): void
    {
        $this->priceProductPriceListRepositoryMock->expects(static::atLeastOnce())
            ->method('buildUnconditionalPriceListPriceDimensionCriteria')
            ->willReturn($this->queryCriteriaTransferMock);

        static::assertEquals(
            $this->queryCriteriaTransferMock,
            $this->priceListPriceQueryCriteriaPlugin->buildUnconditionalPriceDimensionQueryCriteria(),
        );
    }

    /**
     * @return void
     */
    public function testGetDimensionName(): void
    {
        static::assertSame(
            PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST,
            $this->priceListPriceQueryCriteriaPlugin->getDimensionName(),
        );
    }
}
