<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use Generated\Shared\Transfer\FilterFieldTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class IdCustomerFilterTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\FilterFieldTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|FilterFieldTransfer $filterFieldTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilter
     */
    protected IdCustomerFilter $idCustomerFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->filterFieldTransferMock = $this->getMockBuilder(FilterFieldTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCustomerFilter = new IdCustomerFilter();
    }

    /**
     * @return void
     */
    public function testFilterByFilterField(): void
    {
        $idCustomer = 1;

        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER);

        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn($idCustomer);

        static::assertEquals(
            $idCustomer,
            $this->idCustomerFilter->filterByFilterField($this->filterFieldTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFilterByFilterFieldWithInvalidType(): void
    {
        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn('foo');

        $this->filterFieldTransferMock->expects(static::never())
            ->method('getValue');

        static::assertEquals(
            null,
            $this->idCustomerFilter->filterByFilterField($this->filterFieldTransferMock),
        );
    }
}
