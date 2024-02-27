<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence\CompanyTypeProductListsBulkRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyTypeProductListsBulkRestApiBusinessFactoryTest extends Unit
{
    protected MockObject|CompanyTypeProductListsBulkRestApiRepository $repositoryMock;

    protected CompanyTypeProductListsBulkRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyTypeProductListsBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyTypeProductListsBulkRestApiBusinessFactory();
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateRestProductListsBulkRequestExpander(): void
    {
        static::assertInstanceOf(
            RestProductListsBulkRequestExpander::class,
            $this->factory->createRestProductListsBulkRequestExpander(),
        );
    }
}
