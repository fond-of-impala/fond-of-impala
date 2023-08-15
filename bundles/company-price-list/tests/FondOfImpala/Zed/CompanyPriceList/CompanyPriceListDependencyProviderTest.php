<?php

namespace FondOfImpala\Zed\CompanyPriceList;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CompanyPriceListDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyPriceList\CompanyPriceListDependencyProvider
     */
    protected CompanyPriceListDependencyProvider $companyPriceListDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyPriceListDependencyProvider = new CompanyPriceListDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->companyPriceListDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
