<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model\CompanyBusinessUnitExpanderInterface;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\CompanyBusinessUnitPriceListDependencyProvider;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CompanyBusinessUnitPriceListBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListBusinessFactory
     */
    protected CompanyBusinessUnitPriceListBusinessFactory $companyBusinessUnitPriceListBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model\CompanyBusinessUnitExpanderInterface
     */
    protected MockObject|CompanyBusinessUnitExpanderInterface $companyBusinessUnitPriceListToPriceListFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitPriceListToPriceListFacadeInterfaceMock = $this->getMockBuilder(CompanyBusinessUnitPriceListToPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitPriceListBusinessFactory = new CompanyBusinessUnitPriceListBusinessFactory();
        $this->companyBusinessUnitPriceListBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyBusinessUnitPriceListDependencyProvider::FACADE_PRICE_LIST)
            ->willReturn($this->companyBusinessUnitPriceListToPriceListFacadeInterfaceMock);

        static::assertInstanceOf(
            CompanyBusinessUnitExpanderInterface::class,
            $this->companyBusinessUnitPriceListBusinessFactory->createCompanyBusinessUnitExpander(),
        );
    }
}
