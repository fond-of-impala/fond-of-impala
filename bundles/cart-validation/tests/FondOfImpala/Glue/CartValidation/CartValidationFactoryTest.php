<?php

namespace FondOfImpala\Glue\CartValidation;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface;
use FondOfImpala\Glue\CartValidation\Processor\Translator\ValidationMessageTranslator;
use Spryker\Glue\Kernel\Container;

class CartValidationFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CartValidation\CartValidationFactory
     */
    protected $cartValidationFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface
     */
    protected $glossaryStorageClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface
     */
    protected $localeClientInterfaceMock;

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
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                if ($key === CartValidationDependencyProvider::CLIENT_GLOSSARY_STORAGE) {
                    return $self->glossaryStorageClientInterfaceMock;
                }

                if ($key === CartValidationDependencyProvider::CLIENT_LOCALE) {
                    return $self->localeClientInterfaceMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            ValidationMessageTranslator::class,
            $this->cartValidationFactory->createValidationMessageTranslator(),
        );
    }
}
