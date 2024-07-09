<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\DocumentTypeErpOrder\Business\Builder\EasyApiFilterBuilder;
use FondOfImpala\Zed\DocumentTypeErpOrder\DocumentTypeErpOrderConfig;
use FondOfImpala\Zed\DocumentTypeErpOrder\Persistence\DocumentTypeErpOrderRepository;
use PHPUnit\Framework\MockObject\MockObject;

class DocumentTypeErpOrderBusinessFactoryTest extends Unit
{
    protected MockObject|DocumentTypeErpOrderRepository $repositoryMock;

    protected MockObject|DocumentTypeErpOrderConfig $configMock;

    protected DocumentTypeErpOrderBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(DocumentTypeErpOrderRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(DocumentTypeErpOrderConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new DocumentTypeErpOrderBusinessFactory();
        $this->factory->setRepository($this->repositoryMock);
        $this->factory->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testCreateEasyApiFilterBuilder(): void
    {
        static::assertInstanceOf(
            EasyApiFilterBuilder::class,
            $this->factory->createEasyApiFilterBuilder(),
        );
    }
}
