<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander\QueryJoinCollectionExpander;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepository;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyCartSearchRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCartSearchRestApiRepository $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\CompanyCartSearchRestApiBusinessFactory
     */
    protected CompanyCartSearchRestApiBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyCartSearchRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyCartSearchRestApiBusinessFactory();
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateQueryJoinCollectionExpander(): void
    {
        static::assertInstanceOf(
            QueryJoinCollectionExpander::class,
            $this->factory->createQueryJoinCollectionExpander(),
        );
    }
}
