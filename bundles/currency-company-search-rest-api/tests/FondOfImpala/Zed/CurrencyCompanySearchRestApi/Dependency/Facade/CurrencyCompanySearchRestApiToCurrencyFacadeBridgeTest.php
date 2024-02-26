<?php

namespace FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;

class CurrencyCompanySearchRestApiToCurrencyFacadeBridgeTest extends Unit
{
    protected CurrencyFacadeInterface|MockObject $facadeMock;

    protected MockObject|CurrencyTransfer $currencyTransferMock;

    protected CurrencyCompanySearchRestApiToCurrencyFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CurrencyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CurrencyCompanySearchRestApiToCurrencyFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testGetByIdCurrency(): void
    {
        $idCurrency = 1;

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getByIdCurrency')
            ->with($idCurrency)
            ->willReturn($this->currencyTransferMock);

        static::assertEquals(
            $this->currencyTransferMock,
            $this->bridge->getByIdCurrency($idCurrency),
        );
    }
}
