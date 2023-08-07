<?php

namespace FondOfImpala\Zed\PriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Business\Model\PriceListReader;
use FondOfImpala\Zed\PriceList\Business\Model\PriceListWriter;
use FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManager;
use FondOfImpala\Zed\PriceList\Persistence\PriceListRepository;
use FondOfImpala\Zed\PriceList\PriceListDependencyProvider;
use Spryker\Zed\Kernel\Container;

class PriceListBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Persistence\PriceListRepository
     */
    protected $priceListRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManager
     */
    protected $priceListEntityManagerMock;

    /**
     * @var \FondOfImpala\Zed\PriceList\Business\PriceListBusinessFactory
     */
    protected $priceListBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListRepositoryMock = $this->getMockBuilder(PriceListRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListEntityManagerMock = $this->getMockBuilder(PriceListEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListBusinessFactory = new PriceListBusinessFactory();
        $this->priceListBusinessFactory->setContainer($this->containerMock);
        $this->priceListBusinessFactory->setRepository($this->priceListRepositoryMock);
        $this->priceListBusinessFactory->setEntityManager($this->priceListEntityManagerMock);
    }

    /**
     * @return void
     */
    public function testCreatePriceListReader(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(PriceListDependencyProvider::PLUGINS_SEARCH_PRICE_LIST_QUERY_EXPANDER)
            ->willReturn([]);

        static::assertInstanceOf(
            PriceListReader::class,
            $this->priceListBusinessFactory->createPriceListReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreatePriceListWriter(): void
    {
        static::assertInstanceOf(
            PriceListWriter::class,
            $this->priceListBusinessFactory->createPriceListWriter(),
        );
    }
}
