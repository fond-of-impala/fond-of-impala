<?php

namespace FondOfImpala\Glue\CartValidation;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface;
use FondOfImpala\Glue\CartValidation\Processor\Translator\ValidationMessageTranslator;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\Kernel\Container;

class CartValidationFactoryTest extends Unit
{
    protected CartValidationFactory $cartValidationFactory;

    protected MockObject|Container $containerMock;

    protected MockObject|CartValidationToGlossaryStorageClientInterface $glossaryStorageClientInterfaceMock;

    protected MockObject|CartValidationToLocaleClientInterface $localeClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->glossaryStorageClientInterfaceMock = $this->getMockBuilder(CartValidationToGlossaryStorageClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeClientInterfaceMock = $this->getMockBuilder(CartValidationToLocaleClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartValidationFactory = new CartValidationFactory();
        $this->cartValidationFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateValidationTranslator(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CartValidationDependencyProvider::CLIENT_GLOSSARY_STORAGE],
                [CartValidationDependencyProvider::CLIENT_LOCALE],
            )->willReturnOnConsecutiveCalls(
                $this->glossaryStorageClientInterfaceMock,
                $this->localeClientInterfaceMock,
            );

        static::assertInstanceOf(
            ValidationMessageTranslator::class,
            $this->cartValidationFactory->createValidationMessageTranslator(),
        );
    }
}
