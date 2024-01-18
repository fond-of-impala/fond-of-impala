<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

class RestCompanyBusinessUnitCartListMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer
     */
    protected $restCompanyBusinessUnitCartListTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\RestCompanyBusinessUnitCartListMapper
     */
    protected $restCompanyBusinessUnitCartListMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCompanyBusinessUnitCartListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitCartListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitCartListMapper = new RestCompanyBusinessUnitCartListMapper();
    }

    /**
     * @return void
     */
    public function testMapToCompanyBusinessUnitQuoteListRequestTransfer(): void
    {
        $idCustomer = 1;

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('toArray')
            ->willReturn(['id_customer' => $idCustomer]);

        $companyBusinessUnitQuoteListRequestTransfer = $this->restCompanyBusinessUnitCartListMapper
            ->mapToCompanyBusinessUnitQuoteListRequestTransfer(
                $this->restCompanyBusinessUnitCartListTransferMock,
            );

        self::assertEquals(
            $idCustomer,
            $companyBusinessUnitQuoteListRequestTransfer->getIdCustomer(),
        );
    }
}
