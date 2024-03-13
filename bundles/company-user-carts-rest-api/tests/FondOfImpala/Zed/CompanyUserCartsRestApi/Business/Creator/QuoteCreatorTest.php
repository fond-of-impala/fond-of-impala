<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Shared\CompanyUserCartsRestApi\CompanyUserCartsRestApiConstants;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapperInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface;
use Throwable;

class QuoteCreatorTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserReaderInterface $companyUserReaderMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapperInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteMapperInterface $quoteMapperMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteFinderInterface|MockObject $quoteFinderMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteHandlerInterface $quoteHandlerMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected WritePermissionCheckerInterface|MockObject $writePermissionCheckerMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCartsRestApiToQuoteFacadeInterface|MockObject $quoteFacadeMock;

    /**
     * @var (\Psr\Log\LoggerInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected LoggerInterface|MockObject $loggerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteCreateExpanderInterface|MockObject $quoteCreateExpanderMock;

    /**
     * @var (\Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected TransactionHandlerInterface|MockObject $transactionHandlerMock;

    /**
     * @var (\Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteTransfer $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteResponseTransfer $quoteResponseTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUserCartsResponseTransfer|MockObject $restCompanyUserCartsResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator\QuoteCreator
     */
    protected QuoteCreator $quoteCreator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteMapperMock = $this->getMockBuilder(QuoteMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteHandlerMock = $this->getMockBuilder(QuoteHandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFinderMock = $this->getMockBuilder(QuoteFinderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCreateExpanderMock = $this->getMockBuilder(QuoteCreateExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->writePermissionCheckerMock = $this->getMockBuilder(WritePermissionCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transactionHandlerMock = $this->getMockBuilder(TransactionHandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsResponseTransferMock = $this->getMockBuilder(RestCompanyUserCartsResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCreator = new class (
            $this->companyUserReaderMock,
            $this->quoteMapperMock,
            $this->quoteHandlerMock,
            $this->quoteFinderMock,
            $this->writePermissionCheckerMock,
            $this->quoteFacadeMock,
            $this->quoteCreateExpanderMock,
            $this->loggerMock,
            $this->transactionHandlerMock
        ) extends QuoteCreator {
            /**
             * @var \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            protected TransactionHandlerInterface $transactionHandler;

            /**
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface $companyUserReader
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapperInterface $quoteMapper
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface $quoteHandler
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface $quoteFinder
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface $writePermissionChecker
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface $quoteCreateExpander
             * @param \Psr\Log\LoggerInterface $logger
             * @param \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface $transactionHandler
             */
            public function __construct(
                CompanyUserReaderInterface $companyUserReader,
                QuoteMapperInterface $quoteMapper,
                QuoteHandlerInterface $quoteHandler,
                QuoteFinderInterface $quoteFinder,
                WritePermissionCheckerInterface $writePermissionChecker,
                CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade,
                QuoteCreateExpanderInterface $quoteCreateExpander,
                LoggerInterface $logger,
                TransactionHandlerInterface $transactionHandler
            ) {
                parent::__construct(
                    $companyUserReader,
                    $quoteMapper,
                    $quoteHandler,
                    $quoteFinder,
                    $writePermissionChecker,
                    $quoteFacade,
                    $quoteCreateExpander,
                    $logger,
                );

                $this->transactionHandler = $transactionHandler;
            }

            /**
             * @return \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            public function getTransactionHandler(): TransactionHandlerInterface
            {
                return $this->transactionHandler;
            }
        };
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $idQuote = 1;
        $idCompanyUser = 10;

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn(true);

        $this->quoteMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('createQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteHandlerMock->expects(static::atLeastOnce())
            ->method('handle')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->quoteCreateExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('updateQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteFinderMock->expects(static::atLeastOnce())
            ->method('findByIdQuote')
            ->with($idQuote)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->quoteCreator->createByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testCreateWithInvalidHandle(): void
    {
        $idQuote = 1;
        $idCompanyUser = 10;

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn(true);

        $this->quoteMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('createQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteHandlerMock->expects(static::atLeastOnce())
            ->method('handle')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->quoteCreateExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::never())
            ->method('updateQuote');

        $this->quoteFinderMock->expects(static::never())
            ->method('findByIdQuote');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->quoteCreator->createByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testCreateWithNonExistingQuote(): void
    {
        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(null);

        $this->writePermissionCheckerMock->expects(static::never())
            ->method('checkByCompanyUser');

        $this->quoteMapperMock->expects(static::never())
            ->method('fromRestCompanyUserCartsRequest');

        $this->quoteFacadeMock->expects(static::never())
            ->method('createQuote');

        $this->quoteHandlerMock->expects(static::never())
            ->method('handle');

        $this->quoteFacadeMock->expects(static::never())
            ->method('updateQuote');

        $this->quoteFinderMock->expects(static::never())
            ->method('findByIdQuote');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $restCompanyUserCartsResponseTransfer = $this->quoteCreator->createByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());

        static::assertEquals(
            CompanyUserCartsRestApiConstants::ERROR_MESSAGE_COMPANY_USER_NOT_FOUND,
            $restCompanyUserCartsResponseTransfer->getErrors()
                ->offsetGet(0)
                ->getMessage(),
        );
    }

    /**
     * @return void
     */
    public function testCreateWithError(): void
    {
        $idCompanyUser = 10;
        $quoteErrorTransfer = (new QuoteErrorTransfer())->setMessage('Foo');

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn(true);

        $this->quoteMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('createQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn(null);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject([$quoteErrorTransfer]));

        $this->quoteResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $this->quoteHandlerMock->expects(static::never())
            ->method('handle');

        $this->quoteFacadeMock->expects(static::never())
            ->method('updateQuote');

        $this->quoteFinderMock->expects(static::never())
            ->method('findByIdQuote');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $this->quoteCreateExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->quoteTransferMock);

        $restCompanyUserCartsResponseTransfer = $this->quoteCreator->createByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());

        static::assertEquals(
            $quoteErrorTransfer->getMessage(),
            $restCompanyUserCartsResponseTransfer->getErrors()
                ->offsetGet(0)
                ->getMessage(),
        );
    }

    /**
     * @return void
     */
    public function testCreateWithInvalidUpdate(): void
    {
        $idQuote = 1;
        $idCompanyUser = 10;
        $quoteErrorTransfer = (new QuoteErrorTransfer())->setMessage('Foo');

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn(true);

        $this->quoteMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('createQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturnOnConsecutiveCalls($this->quoteTransferMock, null);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject([$quoteErrorTransfer]));

        $this->quoteHandlerMock->expects(static::atLeastOnce())
            ->method('handle')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('updateQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteFinderMock->expects(static::never())
            ->method('findByIdQuote');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $this->quoteCreateExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->quoteTransferMock);

        $restCompanyUserCartsResponseTransfer = $this->quoteCreator->createByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());

        static::assertEquals(
            $quoteErrorTransfer->getMessage(),
            $restCompanyUserCartsResponseTransfer->getErrors()
                ->offsetGet(0)
                ->getMessage(),
        );
    }

    /**
     * @return void
     */
    public function testCreateWithException(): void
    {
        $exception = new Exception('Foo bar');

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willThrowException($exception);

        $this->companyUserReaderMock->expects(static::never())
            ->method('getByRestCompanyUserCartsRequest');

        $this->writePermissionCheckerMock->expects(static::never())
            ->method('checkByCompanyUser');

        $this->quoteMapperMock->expects(static::never())
            ->method('fromRestCompanyUserCartsRequest');

        $this->quoteFacadeMock->expects(static::never())
            ->method('createQuote');

        $this->quoteHandlerMock->expects(static::never())
            ->method('handle');

        $this->quoteFacadeMock->expects(static::never())
            ->method('updateQuote');

        $this->quoteFinderMock->expects(static::never())
            ->method('findByIdQuote');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('serialize')
            ->willReturn('{...}');

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error')
            ->with(
                'Quote could not be created.',
                [
                    'exception' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                    'data' => '{...}',
                ],
            );

        try {
            $this->quoteCreator->createByRestCompanyUserCartsRequest(
                $this->restCompanyUserCartsRequestTransferMock,
            );
            static::fail();
        } catch (Throwable $throwable) {
            static::assertEquals($exception, $throwable);
        }
    }

    /**
     * @return void
     */
    public function testCreateWithoutPermission(): void
    {
        $idCompanyUser = 10;

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn(false);

        $this->quoteMapperMock->expects(static::never())
            ->method('fromRestCompanyUserCartsRequest');

        $this->quoteFacadeMock->expects(static::never())
            ->method('createQuote');

        $this->quoteHandlerMock->expects(static::never())
            ->method('handle');

        $this->quoteFacadeMock->expects(static::never())
            ->method('updateQuote');

        $this->quoteFinderMock->expects(static::never())
            ->method('findByIdQuote');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('serialize');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $restCompanyUserCartsResponseTransfer = $this->quoteCreator->createByRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());

        static::assertEquals(
            CompanyUserCartsRestApiConstants::ERROR_MESSAGE_PERMISSION_DENIED,
            $restCompanyUserCartsResponseTransfer->getErrors()
                ->offsetGet(0)
                ->getMessage(),
        );
    }
}
