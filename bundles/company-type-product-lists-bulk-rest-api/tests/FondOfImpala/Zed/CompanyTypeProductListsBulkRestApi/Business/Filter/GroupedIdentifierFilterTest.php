<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Filter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

class GroupedIdentifierFilterTest extends Unit
{
    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->groupedIdentifierFilter = new GroupedIdentifierFilter();
    }

}
