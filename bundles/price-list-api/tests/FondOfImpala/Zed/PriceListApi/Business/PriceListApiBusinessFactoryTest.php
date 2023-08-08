<?php

namespace FondOfImpala\Zed\PriceListApi\Business;

use Codeception\Test\Unit;
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
use Propel\Runtime\Connection\ConnectionInterface;
use Spryker\Zed\Kernel\Container;

class PriceListApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Business\PriceListApiBusinessFactory
     */
    protected $priceListApiBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeInterface
     */
    protected $priceListApiToProductFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Propel\Runtime\Connection\ConnectionInterface
     */
    private $connectionInterfaceMock;

    private ?array $priceProductHydrationPlugins = null;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeInterface
     */
    private $facadePriceListMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceProductPriceListFacadeInterface
     */
    private $facadePriceProductPriceListMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeInterface
     */
    private $queryContainerApiMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Dependency\QueryContainer\PriceListApiToApiQueryBuilderQueryContainerInterface
     */
    private $queryContainerApiQueryBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainer
     */
    protected $queryContainerMock;

    /**
     * @var \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

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
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [PriceListApiDependencyProvider::PROPEL_CONNECTION],
                [PriceListApiDependencyProvider::FACADE_PRICE_LIST],
                [PriceListApiDependencyProvider::FACADE_PRICE_PRODUCT_PRICE_LIST],
                [PriceListApiDependencyProvider::FACADE_API],
                [PriceListApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER],
                [PriceListApiDependencyProvider::PLUGINS_PRICE_PRODUCTS_HYDRATION],
            )->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [PriceListApiDependencyProvider::PROPEL_CONNECTION],
                [PriceListApiDependencyProvider::FACADE_PRICE_LIST],
                [PriceListApiDependencyProvider::FACADE_PRICE_PRODUCT_PRICE_LIST],
                [PriceListApiDependencyProvider::FACADE_API],
                [PriceListApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER],
                [PriceListApiDependencyProvider::PLUGINS_PRICE_PRODUCTS_HYDRATION],
            )
            ->willReturnOnConsecutiveCalls(
                $this->connectionInterfaceMock,
                $this->facadePriceListMock,
                $this->facadePriceProductPriceListMock,
                $this->queryContainerApiMock,
                $this->queryContainerApiQueryBuilderMock,
                $this->priceProductHydrationPlugins,
            );

        static::assertInstanceOf(
            PriceListApi::class,
            $this->priceListApiBusinessFactory->createProductListApi(),
        );
    }
}
