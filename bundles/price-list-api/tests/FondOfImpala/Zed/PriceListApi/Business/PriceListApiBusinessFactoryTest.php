<?php

namespace FondOfImpala\Zed\PriceListApi\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\PriceListApi\Business\Hydrator\PriceProductsHydrator;
use FondOfImpala\Zed\PriceListApi\Business\Model\PriceListApi;
use FondOfImpala\Zed\PriceListApi\Business\Validator\PriceListApiValidator;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeBridge;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceProductPriceListFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\QueryContainer\PriceListApiToApiQueryBuilderQueryContainerInterface;
use FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainer;
use FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiRepository;
use FondOfImpala\Zed\PriceListApi\PriceListApiDependencyProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Propel\Runtime\Connection\ConnectionInterface;
use Spryker\Zed\Kernel\Container;

class PriceListApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Business\PriceListApiBusinessFactory
     */
    protected PriceListApiBusinessFactory $priceListApiBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeInterface
     */
    protected MockObject|PriceListApiToProductFacadeInterface $priceListApiToProductFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Propel\Runtime\Connection\ConnectionInterface
     */
    private MockObject|ConnectionInterface $connectionInterfaceMock;

    private array $priceProductHydrationPlugins = [];

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeInterface
     */
    private MockObject|PriceListApiToPriceListFacadeInterface $facadePriceListMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceProductPriceListFacadeInterface
     */
    private MockObject|PriceListApiToPriceProductPriceListFacadeInterface $facadePriceProductPriceListMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeInterface
     */
    private MockObject|PriceListApiToApiFacadeInterface $queryContainerApiMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\QueryContainer\PriceListApiToApiQueryBuilderQueryContainerInterface
     */
    private MockObject|PriceListApiToApiQueryBuilderQueryContainerInterface $queryContainerApiQueryBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainer
     */
    protected MockObject|PriceListApiQueryContainer $queryContainerMock;

    /**
     * @var \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceListApiRepositoryInterface $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListApiToProductFacadeInterfaceMock = $this->getMockBuilder(PriceListApiToProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->connectionInterfaceMock = $this->getMockBuilder(ConnectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadePriceListMock = $this->getMockBuilder(PriceListApiToPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadePriceProductPriceListMock = $this->getMockBuilder(PriceListApiToPriceProductPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryContainerApiMock = $this->getMockBuilder(PriceListApiToApiFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryContainerMock = $this->getMockBuilder(PriceListApiQueryContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryContainerApiQueryBuilderMock = $this->getMockBuilder(PriceListApiToApiQueryBuilderQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(PriceListApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductHydrationPlugins = [];

        $this->priceListApiBusinessFactory = new PriceListApiBusinessFactory();

        $this->priceListApiBusinessFactory->setContainer($this->containerMock);
        $this->priceListApiBusinessFactory->setRepository($this->repositoryMock);
        $this->priceListApiBusinessFactory->setQueryContainer($this->queryContainerMock);
    }

    /**
     * @return void
     */
    public function testCreatePriceProductsHydrator(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(PriceListApiDependencyProvider::FACADE_PRODUCT)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(PriceListApiDependencyProvider::FACADE_PRODUCT)
            ->willReturn($this->priceListApiToProductFacadeInterfaceMock);

        static::assertInstanceOf(
            PriceProductsHydrator::class,
            $this->priceListApiBusinessFactory->createPriceProductsHydrator(),
        );
    }

    /**
     * @return void
     */
    public function testPriceListApiValidator(): void
    {
        static::assertInstanceOf(
            PriceListApiValidator::class,
            $this->priceListApiBusinessFactory->createPriceListApiValidator(),
        );
    }

    /**
     * @return void
     */
    public function testCreateProductListApi(): void
    {
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case PriceListApiDependencyProvider::PROPEL_CONNECTION:
                        return $self->connectionInterfaceMock;
                    case PriceListApiDependencyProvider::FACADE_PRICE_LIST:
                        return $self->facadePriceListMock;
                    case PriceListApiDependencyProvider::FACADE_PRICE_PRODUCT_PRICE_LIST:
                        return $self->facadePriceProductPriceListMock;
                    case PriceListApiDependencyProvider::FACADE_API:
                        return $self->queryContainerApiMock;
                    case PriceListApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER:
                        return $self->queryContainerApiQueryBuilderMock;
                    case PriceListApiDependencyProvider::PLUGINS_PRICE_PRODUCTS_HYDRATION:
                        return $self->priceProductHydrationPlugins;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            PriceListApi::class,
            $this->priceListApiBusinessFactory->createProductListApi(),
        );
    }
}
