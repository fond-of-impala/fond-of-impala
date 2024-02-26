<?php

namespace FondOfImpala\Zed\CurrencyCompanySearchRestApi\Communication;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CurrencyCompanySearchRestApi\CurrencyCompanySearchRestApiDependencyProvider;
use FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade\CurrencyCompanySearchRestApiToCurrencyFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CurrencyCompanySearchRestApiCommunicationFactoryTest extends Unit
{
    protected Container|MockObject $containerMock;

    protected CurrencyCompanySearchRestApiToCurrencyFacadeInterface|MockObject $currencyFacadeMock;

    protected CurrencyCompanySearchRestApiCommunicationFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyFacadeMock = $this->getMockBuilder(CurrencyCompanySearchRestApiToCurrencyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CurrencyCompanySearchRestApiCommunicationFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetCurrencyFacade(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(CurrencyCompanySearchRestApiDependencyProvider::FACADE_CURRENCY)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CurrencyCompanySearchRestApiDependencyProvider::FACADE_CURRENCY)
            ->willReturn($this->currencyFacadeMock);

        static::assertEquals(
            $this->currencyFacadeMock,
            $this->factory->getCurrencyFacade(),
        );
    }
}
