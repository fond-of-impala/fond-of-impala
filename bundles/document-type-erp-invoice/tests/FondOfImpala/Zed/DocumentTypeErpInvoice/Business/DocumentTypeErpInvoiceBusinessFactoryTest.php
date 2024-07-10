<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\DocumentTypeErpInvoice\Business\Builder\EasyApiFilterBuilder;
use FondOfImpala\Zed\DocumentTypeErpInvoice\DocumentTypeErpInvoiceConfig;
use FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence\DocumentTypeErpInvoiceRepository;
use PHPUnit\Framework\MockObject\MockObject;

class DocumentTypeErpInvoiceBusinessFactoryTest extends Unit
{
    protected MockObject|DocumentTypeErpInvoiceRepository $repositoryMock;

    protected MockObject|DocumentTypeErpInvoiceConfig $configMock;

    protected DocumentTypeErpInvoiceBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(DocumentTypeErpInvoiceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(DocumentTypeErpInvoiceConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new DocumentTypeErpInvoiceBusinessFactory();
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
