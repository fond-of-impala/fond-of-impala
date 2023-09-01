<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceListPriceWriterInterface;
use FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceProductDimensionExpanderInterface;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManager;
use FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepository;
use FondOfImpala\Zed\PriceProductPriceList\PriceProductPriceListDependencyProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListBusinessFactory
     */
    protected PriceProductPriceListBusinessFactory $priceProductPriceListBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepository
     */
    protected MockObject|PriceProductPriceListRepository $priceProductPriceListRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManager
     */
    protected MockObject|PriceProductPriceListEntityManager $priceProductPriceListEntityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface
     */
    protected MockObject|PriceProductPriceListToPriceListFacadeInterface $priceProductPriceListToPriceListFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface
     */
    protected MockObject|PriceProductPriceListToPriceProductFacadeInterface $priceProductPriceListToPriceProductFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListRepositoryMock = $this->getMockBuilder(PriceProductPriceListRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListEntityManagerMock = $this->getMockBuilder(PriceProductPriceListEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListToPriceListFacadeInterfaceMock = $this->getMockBuilder(PriceProductPriceListToPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListToPriceProductFacadeInterfaceMock = $this->getMockBuilder(PriceProductPriceListToPriceProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListBusinessFactory = new PriceProductPriceListBusinessFactory();
        $this->priceProductPriceListBusinessFactory->setRepository($this->priceProductPriceListRepositoryMock);
        $this->priceProductPriceListBusinessFactory->setEntityManager($this->priceProductPriceListEntityManagerMock);
        $this->priceProductPriceListBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreatePriceProductDimensionExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(PriceProductPriceListDependencyProvider::FACADE_PRICE_LIST)
            ->willReturn($this->priceProductPriceListToPriceListFacadeInterfaceMock);

        static::assertInstanceOf(PriceProductDimensionExpanderInterface::class, $this->priceProductPriceListBusinessFactory->createPriceProductDimensionExpander());
    }

    /**
     * @return void
     */
    public function testCreatePriceListPriceWrite(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(PriceProductPriceListDependencyProvider::FACADE_PRICE_PRODUCT)
            ->willReturn($this->priceProductPriceListToPriceProductFacadeInterfaceMock);

        static::assertInstanceOf(PriceListPriceWriterInterface::class, $this->priceProductPriceListBusinessFactory->createPriceListPriceWriter());
    }
}
