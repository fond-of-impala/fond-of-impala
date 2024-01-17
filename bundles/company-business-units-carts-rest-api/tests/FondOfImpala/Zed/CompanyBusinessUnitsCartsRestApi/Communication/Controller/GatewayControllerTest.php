<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Communication\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\CompanyBusinessUnitsCartsRestApiFacade;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class GatewayControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyBusinessUnitsCartsRestApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer
     */
    protected $restCompanyBusinessUnitCartListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    protected $companyBusinessUnitQuoteListTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Communication\Controller\GatewayController
     */
    protected $gatewayController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitsCartsRestApiFacadeMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitCartListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitCartListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayController = new class ($this->companyBusinessUnitsCartsRestApiFacadeMock) extends GatewayController {
            /**
             * @var \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected $facade;

            /**
             * @param \Spryker\Zed\Kernel\Business\AbstractFacade $facade
             */
            public function __construct(AbstractFacade $facade)
            {
                $this->facade = $facade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->facade;
            }
        };
    }

    /**
     * @return void
     */
    public function testFindOrdersAction(): void
    {
        $this->companyBusinessUnitsCartsRestApiFacadeMock->expects(self::atLeastOnce())
            ->method('findQuotes')
            ->with($this->restCompanyBusinessUnitCartListTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->gatewayController->findQuotesAction(
            $this->restCompanyBusinessUnitCartListTransferMock,
        );

        self::assertEquals(
            $this->companyBusinessUnitQuoteListTransferMock,
            $companyBusinessUnitOrderListTransfer,
        );
    }
}
