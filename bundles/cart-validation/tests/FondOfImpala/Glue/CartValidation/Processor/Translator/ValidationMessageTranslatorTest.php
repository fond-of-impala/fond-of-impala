<?php

namespace FondOfImpala\Glue\CartValidation\Processor\Translator;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource;

class ValidationMessageTranslatorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface
     */
    protected $glossaryStorageClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Locale\LocaleClientInterface
     */
    protected $localeClientInterfaceMock;

    /**
     * @var array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $restResourceMocks;

    /**
     * @var array<\Generated\Shared\Transfer\MessageTransfer>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $messageTransferMocks;

    /**
     * @var array
     */
    protected $relationships;

    /**
     * @var \Generated\Shared\Transfer\RestCartsAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $restCartsAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestItemsAttributesTransfer
     */
    protected $restItemsAttributesTransferMock;

    /**
     * @var \FondOfImpala\Glue\CartValidation\Processor\Translator\ValidationMessageTranslator
     */
    protected $validationMessageTranslator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->glossaryStorageClientInterfaceMock = $this->getMockBuilder(CartValidationToGlossaryStorageClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeClientInterfaceMock = $this->getMockBuilder(CartValidationToLocaleClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMocks = [
            $this->getMockBuilder(RestResource::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->messageTransferMocks = [
              $this->getMockBuilder(MessageTransfer::class)
                  ->disableOriginalConstructor()
                  ->getMock(),
        ];

        $this->relationships = [
            'items' => [
                $this->getMockBuilder(RestResource::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
            ],
        ];

        $this->restCartsAttributesTransferMock = $this->getMockBuilder(RestCartsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restItemsAttributesTransferMock = $this->getMockBuilder(RestItemsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validationMessageTranslator = new ValidationMessageTranslator(
            $this->glossaryStorageClientInterfaceMock,
            $this->localeClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testTranslateOnlyOnQuoteLevel(): void
    {
        $untranslatedValue = 'foo';
        $translatedValue = 'bar';
        $parameters = [];
        $locale = 'de_DE';

        $this->restResourceMocks[0]->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restCartsAttributesTransferMock);

        $this->restCartsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getValidationMessages')
            ->willReturn(new ArrayObject($this->messageTransferMocks));

        $this->messageTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn($untranslatedValue);

        $this->messageTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getParameters')
            ->willReturn($parameters);

        $this->localeClientInterfaceMock->expects(static::atLeastOnce())
            ->method('getCurrentLocale')
            ->willReturn($locale);

        $this->glossaryStorageClientInterfaceMock->expects(static::atLeastOnce())
            ->method('translate')
            ->with($untranslatedValue, $locale, $parameters)
            ->willReturn($translatedValue);

        $this->messageTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setValue')
            ->with($translatedValue)
            ->willReturn($this->messageTransferMocks[0]);

        $this->messageTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setParameters')
            ->with([])
            ->willReturn($this->messageTransferMocks[0]);

        $this->restResourceMocks[0]->expects(static::atLeastOnce())
            ->method('getRelationships')
            ->willReturn($this->relationships);

        $this->relationships['items'][0]->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restItemsAttributesTransferMock);

        $this->restItemsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getValidationMessages')
            ->willReturn(new ArrayObject());

        static::assertEquals(
            $this->restResourceMocks,
            $this->validationMessageTranslator->translate($this->restResourceMocks),
        );
    }

    /**
     * @return void
     */
    public function testTranslateOnlyOnQuoteItemLevel(): void
    {
        $untranslatedValue = 'foo';
        $translatedValue = 'bar';
        $parameters = [];
        $locale = 'de_DE';

        $this->restResourceMocks[0]->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restCartsAttributesTransferMock);

        $this->restCartsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getValidationMessages')
            ->willReturn(new ArrayObject());

        $this->restResourceMocks[0]->expects(static::atLeastOnce())
            ->method('getRelationships')
            ->willReturn($this->relationships);

        $this->relationships['items'][0]->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restItemsAttributesTransferMock);

        $this->restItemsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getValidationMessages')
            ->willReturn(new ArrayObject($this->messageTransferMocks));

        $this->messageTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn($untranslatedValue);

        $this->messageTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getParameters')
            ->willReturn($parameters);

        $this->localeClientInterfaceMock->expects(static::atLeastOnce())
            ->method('getCurrentLocale')
            ->willReturn($locale);

        $this->glossaryStorageClientInterfaceMock->expects(static::atLeastOnce())
            ->method('translate')
            ->with($untranslatedValue, $locale, $parameters)
            ->willReturn($translatedValue);

        $this->messageTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setValue')
            ->with($translatedValue)
            ->willReturn($this->messageTransferMocks[0]);

        $this->messageTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setParameters')
            ->with([])
            ->willReturn($this->messageTransferMocks[0]);

        static::assertEquals(
            $this->restResourceMocks,
            $this->validationMessageTranslator->translate($this->restResourceMocks),
        );
    }
}
