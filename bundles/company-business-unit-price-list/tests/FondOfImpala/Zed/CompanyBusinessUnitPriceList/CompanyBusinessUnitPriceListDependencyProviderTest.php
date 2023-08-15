<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CompanyBusinessUnitPriceListDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitPriceList\CompanyBusinessUnitPriceListDependencyProvider
     */
    protected CompanyBusinessUnitPriceListDependencyProvider $companyBusinessUnitPriceListDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitPriceListDependencyProvider = new CompanyBusinessUnitPriceListDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->companyBusinessUnitPriceListDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
