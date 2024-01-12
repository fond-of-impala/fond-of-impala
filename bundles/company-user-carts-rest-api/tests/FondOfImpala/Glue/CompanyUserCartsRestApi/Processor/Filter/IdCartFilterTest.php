<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter;

use Codeception\Test\Unit;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class IdCartFilterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCartFilter
     */
    protected $idCartFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCartFilter = new IdCartFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromRestRequest(): void
    {
        $uuid = '681dfaa6-423b-4e2d-b073-670a36754f7a';

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($uuid);

        static::assertEquals(
            $uuid,
            $this->idCartFilter->filterFromRestRequest($this->restRequestMock),
        );
    }
}
