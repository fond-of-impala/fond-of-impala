<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserReferenceFilterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $parentRestResourceMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CompanyUserReferenceFilter
     */
    protected $companyUserReferenceFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->parentRestResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFilter = new CompanyUserReferenceFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromRestRequest(): void
    {
        $companyUserReference = 'FOO--CU-1';

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USERS)
            ->willReturn($this->parentRestResourceMock);

        $this->parentRestResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($companyUserReference);

        static::assertEquals(
            $companyUserReference,
            $this->companyUserReferenceFilter->filterFromRestRequest($this->restRequestMock),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromRestRequestWithInvalidParentResource(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USERS)
            ->willReturn(null);

        static::assertEquals(
            null,
            $this->companyUserReferenceFilter->filterFromRestRequest($this->restRequestMock),
        );
    }
}
