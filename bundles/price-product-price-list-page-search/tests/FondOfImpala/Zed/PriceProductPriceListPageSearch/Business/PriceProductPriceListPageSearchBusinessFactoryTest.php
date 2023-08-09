<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchWriter;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchWriter;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManager;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepository;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListPageSearchBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchBusinessFactory
     */
    protected $priceProductPriceListPageSearchBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepository
     */
    protected $priceProductPriceListPageSearchRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManager
     */
    protected $priceProductPriceListPageSearchEntityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface
     */
    protected $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface
     */
    protected $utilEncodingServiceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductPriceListPageSearchRepositoryMock = $this->getMockBuilder(PriceProductPriceListPageSearchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchEntityManagerMock = $this->getMockBuilder(PriceProductPriceListPageSearchEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(PriceProductPriceListPageSearchToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->utilEncodingServiceMock = $this->getMockBuilder(PriceProductPriceListPageSearchToUtilEncodingServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchBusinessFactory = new PriceProductPriceListPageSearchBusinessFactory();
        $this->priceProductPriceListPageSearchBusinessFactory->setRepository($this->priceProductPriceListPageSearchRepositoryMock);
        $this->priceProductPriceListPageSearchBusinessFactory->setEntityManager($this->priceProductPriceListPageSearchEntityManagerMock);
        $this->priceProductPriceListPageSearchBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreatePriceProductAbstractSearchWrite(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::FACADE_STORE],
                [PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER],
                [PriceProductPriceListPageSearchDependencyProvider::SERVICE_UTIL_ENCODING],
                [PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_DATA_EXPANDER],
            )->willReturnOnConsecutiveCalls(
                true,
                true,
                true,
                true,
            );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::FACADE_STORE],
                [PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER],
                [PriceProductPriceListPageSearchDependencyProvider::SERVICE_UTIL_ENCODING],
                [PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_DATA_EXPANDER],
            )->willReturnOnConsecutiveCalls(
                $this->storeFacadeMock,
                [],
                $this->utilEncodingServiceMock,
                [],
            );

        $this->assertInstanceOf(
            PriceProductAbstractSearchWriter::class,
            $this->priceProductPriceListPageSearchBusinessFactory->createPriceProductAbstractSearchWriter(),
        );
    }

    /**
     * @return void
     */
    public function testCreatePriceProductConcreteSearchWriter(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::FACADE_STORE],
                [PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER],
                [PriceProductPriceListPageSearchDependencyProvider::SERVICE_UTIL_ENCODING],
                [PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_DATA_EXPANDER],
            )->willReturnOnConsecutiveCalls(
                true,
                true,
                true,
                true,
            );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::FACADE_STORE],
                [PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER],
                [PriceProductPriceListPageSearchDependencyProvider::SERVICE_UTIL_ENCODING],
                [PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_DATA_EXPANDER],
            )->willReturnOnConsecutiveCalls(
                $this->storeFacadeMock,
                [],
                $this->utilEncodingServiceMock,
                [],
            );

        $this->assertInstanceOf(
            PriceProductConcreteSearchWriter::class,
            $this->priceProductPriceListPageSearchBusinessFactory->createPriceProductConcreteSearchWriter(),
        );
    }
}
