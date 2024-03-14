<?php

namespace FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Communication\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Communication\CompanyCurrencyPriceProductPriceListSearchRestApiCommunicationFactory;
use FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Facade\CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface;
use Generated\Shared\Transfer\CurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class GatewayControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Communication\CompanyCurrencyPriceProductPriceListSearchRestApiCommunicationFactory
     */
    protected MockObject|CompanyCurrencyPriceProductPriceListSearchRestApiCommunicationFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Facade\CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface
     */
    protected MockObject|CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface $currencyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Communication\Controller\GatewayController
     */
    protected GatewayController $gatewayController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyCurrencyPriceProductPriceListSearchRestApiCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyFacadeMock = $this->getMockBuilder(CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayController = new class ($this->factoryMock) extends GatewayController {
            /**
             * @var \Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory
             */
            protected AbstractCommunicationFactory $factoryMock;

            /**
             * @param \Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory $factoryMock
             */
            public function __construct(AbstractCommunicationFactory $factoryMock)
            {
                $this->factoryMock = $factoryMock;
            }

            /**
             * @return \Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory
             */
            protected function getFactory(): AbstractCommunicationFactory
            {
                return $this->factoryMock;
            }
        };
    }

    /**
     * @return void
     */
    public function testGetCurrencyByIdAction(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCurrencyFacade')
            ->willReturn($this->currencyFacadeMock);

        $this->currencyFacadeMock->expects(static::atLeastOnce())
            ->method('getByIdCurrency')
            ->with(99)
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCurrency')
            ->willReturn(99);

        static::assertEquals(
            $this->currencyTransferMock,
            $this->gatewayController->getCurrencyByIdAction($this->currencyTransferMock),
        );
    }
}
