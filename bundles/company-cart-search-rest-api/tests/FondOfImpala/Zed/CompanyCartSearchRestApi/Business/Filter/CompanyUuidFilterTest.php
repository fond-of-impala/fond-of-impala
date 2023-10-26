<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use Generated\Shared\Transfer\FilterFieldTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUuidFilterTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\FilterFieldTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|FilterFieldTransfer $filterFieldTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilter
     */
    protected CompanyUuidFilter $companyUuidFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->filterFieldTransferMock = $this->getMockBuilder(FilterFieldTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUuidFilter = new CompanyUuidFilter();
    }

    /**
     * @return void
     */
    public function testFilterByFilterField(): void
    {
        $companyUuid = 'd5ffcf7e-183f-4aa1-819e-74acf9f6a134';

        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getType')
            ->willReturn(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_COMPANY_UUID);

        $this->filterFieldTransferMock->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn($companyUuid);

        static::assertEquals(
            $companyUuid,
            $this->companyUuidFilter->filterByFilterField($this->filterFieldTransferMock),
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
            $this->companyUuidFilter->filterByFilterField($this->filterFieldTransferMock),
        );
    }
}
