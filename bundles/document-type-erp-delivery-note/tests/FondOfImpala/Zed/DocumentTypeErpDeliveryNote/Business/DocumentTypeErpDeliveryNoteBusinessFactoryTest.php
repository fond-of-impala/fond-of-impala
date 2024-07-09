<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\Builder\EasyApiFilterBuilder;
use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteConfig;
use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence\DocumentTypeErpDeliveryNoteRepository;
use PHPUnit\Framework\MockObject\MockObject;

class DocumentTypeErpDeliveryNoteBusinessFactoryTest extends Unit
{
    protected MockObject|DocumentTypeErpDeliveryNoteRepository $repositoryMock;

    protected MockObject|DocumentTypeErpDeliveryNoteConfig $configMock;

    protected DocumentTypeErpDeliveryNoteBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new DocumentTypeErpDeliveryNoteBusinessFactory();
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
