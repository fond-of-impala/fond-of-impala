<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence\CompanyProductListsBulkRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyProductListsBulkRestApiBusinessFactoryTest extends Unit
{
    protected MockObject|CompanyProductListsBulkRestApiRepository $repositoryMock;

    protected CompanyProductListsBulkRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyProductListsBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyProductListsBulkRestApiBusinessFactory();
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
