<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyPriceList\Business\Model\CompanyHydratorInterface;
use FondOfImpala\Zed\CompanyPriceList\CompanyPriceListDependencyProvider;
use FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CompanyPriceListBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListBusinessFactory
     */
    protected CompanyPriceListBusinessFactory $companyPriceListBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface
     */
    protected MockObject|CompanyPriceListToPriceListFacadeInterface $companyPriceListToPriceListFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyPriceListToPriceListFacadeInterfaceMock = $this->getMockBuilder(CompanyPriceListToPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyPriceListBusinessFactory = new CompanyPriceListBusinessFactory();
        $this->companyPriceListBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyHydrator(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyPriceListDependencyProvider::FACADE_PRICE_LIST)
            ->willReturn($this->companyPriceListToPriceListFacadeInterfaceMock);

        static::assertInstanceOf(
            CompanyHydratorInterface::class,
            $this->companyPriceListBusinessFactory->createCompanyHydrator(),
        );
    }
}
