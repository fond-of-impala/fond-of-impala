<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence\BusinessCentralProductListsBulkRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;

class BusinessCentralProductListsBulkRestApiBusinessFactoryTest extends Unit
{
    protected MockObject|BusinessCentralProductListsBulkRestApiRepository $repositoryMock;

    protected BusinessCentralProductListsBulkRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(BusinessCentralProductListsBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new BusinessCentralProductListsBulkRestApiBusinessFactory();
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
