<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchWriter;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchWriter;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManager;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepository;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchDependencyProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListPageSearchBusinessFactoryTest extends Unit
{
    protected PriceProductPriceListPageSearchBusinessFactory $priceProductPriceListPageSearchBusinessFactory;

    protected MockObject|PriceProductPriceListPageSearchRepository $priceProductPriceListPageSearchRepositoryMock;

    protected MockObject|PriceProductPriceListPageSearchEntityManager $priceProductPriceListPageSearchEntityManagerMock;

    protected MockObject|Container $containerMock;

    protected MockObject|PriceProductPriceListPageSearchToStoreFacadeInterface $storeFacadeMock;

    protected MockObject|PriceProductPriceListPageSearchToUtilEncodingServiceInterface $utilEncodingServiceMock;

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
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case PriceProductPriceListPageSearchDependencyProvider::FACADE_STORE:
                        return $self->storeFacadeMock;
                    case PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER:
                        return [];
                    case PriceProductPriceListPageSearchDependencyProvider::SERVICE_UTIL_ENCODING:
                        return $self->utilEncodingServiceMock;
                    case PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_DATA_EXPANDER:
                        return [];
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            PriceProductAbstractSearchWriter::class,
            $this->priceProductPriceListPageSearchBusinessFactory->createPriceProductAbstractSearchWriter(),
        );
    }

    /**
     * @return void
     */
    public function testCreatePriceProductConcreteSearchWriter(): void
    {
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case PriceProductPriceListPageSearchDependencyProvider::FACADE_STORE:
                        return $self->storeFacadeMock;
                    case PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER:
                        return [];
                    case PriceProductPriceListPageSearchDependencyProvider::SERVICE_UTIL_ENCODING:
                        return $self->utilEncodingServiceMock;
                    case PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_DATA_EXPANDER:
                        return [];
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            PriceProductConcreteSearchWriter::class,
            $this->priceProductPriceListPageSearchBusinessFactory->createPriceProductConcreteSearchWriter(),
        );
    }
}
