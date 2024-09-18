<?php

namespace FondOfImpala\Shared\ErpOrderCancellation;

interface ErpOrderCancellationConstants
{
    /**
     * @var string
     */
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    public const PREFIX_TO_REPLACE = 'FOI:ERP_ORDER_CANCELLATION:PREFIX_TO_REPLACE';

    /**
     * @var string
     */
    public const DEFAULT_PREFIX_TO_REPLACE = 'PS';

    /**
     * @var string
     */
    public const PREFIX = 'FOI:ERP_ORDER_CANCELLATION:PREFIX';

    /**
     * @var string
     */
    public const DEFAULT_PREFIX = 'PS-OC';
}
