<?php

namespace FondOfImpala\Zed\PriceList\Communication\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Business\PriceListFacade;
use Generated\Shared\Transfer\PriceListListTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class GatewayControllerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceList\Business\PriceListFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceListFacade $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\PriceListListTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceListListTransfer $priceListListTransferMock;

    /**
     * @var \FondOfImpala\Zed\PriceList\Communication\Controller\GatewayController
     */
    protected GatewayController $gatewayController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(PriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListListTransferMock = $this->getMockBuilder(PriceListListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayController = new class ($this->facadeMock) extends GatewayController {
            /**
             * @var \FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface
             */
            protected AbstractFacade $priceListFacade;

            /**
             * @param \Spryker\Zed\Kernel\Business\AbstractFacade $facade
             */
            public function __construct(AbstractFacade $facade)
            {
                $this->priceListFacade = $facade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->priceListFacade;
            }
        };
    }

    /**
     * @return void
     */
    public function testSearchCompaniesAction(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findPriceLists')
            ->with($this->priceListListTransferMock)
            ->willReturn($this->priceListListTransferMock);

        static::assertEquals(
            $this->priceListListTransferMock,
            $this->gatewayController->findPriceListsAction($this->priceListListTransferMock),
        );
    }
}
