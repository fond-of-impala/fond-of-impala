<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacade;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacadeInterface;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class GatewayControllerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiFacadeInterface|MockObject $facadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Controller\GatewayController
     */
    protected GatewayController $gatewayController;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkRequestTransfer|MockObject $restCompanyUsersBulkRequestTransfer;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkResponseTransfer|MockObject $restCompanyUsersBulkResponseTransfer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(CompanyUsersBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkRequestTransfer = $this
            ->getMockBuilder(RestCompanyUsersBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkResponseTransfer = $this
            ->getMockBuilder(RestCompanyUsersBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayController = new class ($this->facadeMock) extends GatewayController {
            /**
             * @var \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected AbstractFacade $companyUsersBulkRestApiFacade;

            /**
             * @param \Spryker\Zed\Kernel\Business\AbstractFacade $facade
             */
            public function __construct(AbstractFacade $facade)
            {
                $this->companyUsersBulkRestApiFacade = $facade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->companyUsersBulkRestApiFacade;
            }
        };
    }

    /**
     * @return void
     */
    public function testBulkProcessAction(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('bulkProcess')
            ->with($this->restCompanyUsersBulkRequestTransfer)
            ->willReturn($this->restCompanyUsersBulkResponseTransfer);

        static::assertEquals(
            $this->restCompanyUsersBulkResponseTransfer,
            $this->gatewayController->bulkProcessAction(
                $this->restCompanyUsersBulkRequestTransfer,
            ),
        );
    }
}
