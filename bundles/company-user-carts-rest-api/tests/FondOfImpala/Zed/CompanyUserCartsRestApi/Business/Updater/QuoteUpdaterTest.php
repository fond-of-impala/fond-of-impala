<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface;
use Throwable;

class QuoteUpdaterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteFinderInterface|MockObject $quoteFinderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteExpanderInterface|MockObject $quoteExpanderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteHandlerInterface $quoteHandlerMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected WritePermissionCheckerInterface|MockObject $writePermissionCheckerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCartsRestApiToQuoteFacadeInterface|MockObject $quoteFacadeMock;

    /**
     * @var \Psr\Log\LoggerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected LoggerInterface|MockObject $loggerMock;

    /**
     * @var \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected TransactionHandlerInterface|MockObject $transactionHandlerMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteTransfer $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|QuoteResponseTransfer $quoteResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUserCartsResponseTransfer|MockObject $restCompanyUserCartsResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater\QuoteUpdater
     */
    protected QuoteUpdater $quoteUpdater;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteFinderMock = $this->getMockBuilder(QuoteFinderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteExpanderMock = $this->getMockBuilder(QuoteExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteHandlerMock = $this->getMockBuilder(QuoteHandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->writePermissionCheckerMock = $this->getMockBuilder(WritePermissionCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToQuoteFacadeInterface::class)
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

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsResponseTransferMock = $this->getMockBuilder(RestCompanyUserCartsResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteUpdater = new class (
            $this->quoteFinderMock,
            $this->quoteExpanderMock,
            $this->quoteHandlerMock,
            $this->writePermissionCheckerMock,
            $this->quoteFacadeMock,
            $this->loggerMock,
            $this->transactionHandlerMock
        ) extends QuoteUpdater {
            /**
             * @var \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            protected TransactionHandlerInterface $transactionHandler;

            /**
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface $quoteFinder
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface $quoteExpander
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface $quoteHandler
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface $writePermissionChecker
             * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade
             * @param \Psr\Log\LoggerInterface $logger
             * @param \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface $transactionHandler
             */
            public function __construct(
                QuoteFinderInterface $quoteFinder,
                QuoteExpanderInterface $quoteExpander,
                QuoteHandlerInterface $quoteHandler,
                WritePermissionCheckerInterface $writePermissionChecker,
                CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade,
                LoggerInterface $logger,
                TransactionHandlerInterface $transactionHandler
            ) {
                parent::__construct(
                    $quoteFinder,
                    $quoteExpander,
                    $quoteHandler,
                    $writePermissionChecker,
                    $quoteFacade,
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
    public function testUpdate(): void
    {
        $idQuote = 1;

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteFinderMock->expects(static::atLeastOnce())
            ->method('findOneByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteHandlerMock->expects(static::atLeastOnce())
            ->method('handle')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('updateQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

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
            $this->quoteUpdater->updateByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdateWithNonExistingQuote(): void
    {
        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteFinderMock->expects(static::atLeastOnce())
            ->method('findOneByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->quoteExpanderMock->expects(static::never())
            ->method('expand');

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

        static::assertEquals(
            $this->restCompanyUserCartsResponseTransferMock,
            $this->quoteUpdater->updateByRestCompanyUserCartsRequest(
                $this->restCompanyUserCartsRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateWithError(): void
    {
        $idQuote = 1;
        $quoteErrorTransfer = (new QuoteErrorTransfer())->setMessage('Foo');

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteFinderMock->expects(static::atLeastOnce())
            ->method('findOneByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteHandlerMock->expects(static::atLeastOnce())
            ->method('handle')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($idQuote);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('updateQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn(null);

        $this->quoteResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject([$quoteErrorTransfer]));

        $this->quoteFinderMock->expects(static::never())
            ->method('findByIdQuote');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $restCompanyUserCartsResponseTransfer = $this->quoteUpdater->updateByRestCompanyUserCartsRequest(
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
    public function testUpdateWithInvalidHandle(): void
    {
        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willReturnCallback(
                static function ($callable) {
                    $callable();
                },
            );

        $this->writePermissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn(true);

        $this->quoteFinderMock->expects(static::atLeastOnce())
            ->method('findOneByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturnOnConsecutiveCalls(true, false);

        $this->quoteExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->quoteHandlerMock->expects(static::atLeastOnce())
            ->method('handle')
            ->with($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

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
            $this->quoteUpdater->updateByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdateWithException(): void
    {
        $exception = new Exception('Foo bar');

        $this->transactionHandlerMock->expects(static::atLeastOnce())
            ->method('handleTransaction')
            ->willThrowException($exception);

        $this->writePermissionCheckerMock->expects(static::never())
            ->method('checkByRestCompanyUserCartsRequest');

        $this->quoteFinderMock->expects(static::never())
            ->method('findOneByRestCompanyUserCartsRequest');

        $this->quoteExpanderMock->expects(static::never())
            ->method('expand');

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
                'Quote could not be updated.',
                [
                    'exception' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                    'data' => '{...}',
                ],
            );

        try {
            $this->quoteUpdater->updateByRestCompanyUserCartsRequest(
                $this->restCompanyUserCartsRequestTransferMock,
            );

            static::fail();
        } catch (Throwable $throwable) {
            static::assertEquals($exception, $throwable);
        }
    }
}
