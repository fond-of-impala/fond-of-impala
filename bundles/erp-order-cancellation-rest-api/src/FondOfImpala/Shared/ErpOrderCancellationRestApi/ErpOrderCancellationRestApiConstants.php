<?php

namespace FondOfImpala\Shared\ErpOrderCancellationRestApi;

interface ErpOrderCancellationRestApiConstants
{
    /**
     * @var string
     */
    public const VALID_ITEMS_PER_PAGE_OPTIONS = 'FOND_OF_IMPALA:ERP_ORDER_CANCELLATION_REST_API:VALID_ITEMS_PER_PAGE_OPTIONS';

    /**
     * @var array
     */
    public const VALID_ITEMS_PER_PAGE_OPTIONS_DEFAULT = [12, 24, 36];

    /**
     * @var string
     */
    public const ITEMS_PER_PAGE = 'FOND_OF_IMPALA:ERP_ORDER_CANCELLATION_REST_API:ITEMS_PER_PAGE';

    /**
     * @var int
     */
    public const ITEMS_PER_PAGE_DEFAULT = 12;

    /**
     * @var string
     */
    public const SORT_FIELDS = 'FOND_OF_IMPALA:COMPANY_ROLE_REST_API:SORT_FIELDS';

    /**
     * @var array
     */
    public const SORT_FIELDS_DEFAULT = ['name'];

    /**
     * @var string
     */
    public const ERROR_MESSAGE_ADD = 'Could not create erp order cancellation!';

    /**
     * @var string
     */
    public const ERROR_CODE_ADD = '1000';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_UPDATE = 'Could not update erp order cancellation!';

    /**
     * @var string
     */
    public const ERROR_CODE_UPDATE = '2000';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_NOT_FOUND = 'Could not find erp order cancellation!';

    /**
     * @var string
     */
    public const ERROR_CODE_NOT_FOUND = '2404';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_DELETE = 'Could not delete erp order cancellation!';

    /**
     * @var string
     */
    public const ERROR_CODE_DELETE = '3000';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_GET = 'Could not fetch erp order cancellation!';

    /**
     * @var string
     */
    public const ERROR_CODE_GET = '4000';

    /**
     * @var string
     */
    public const INTERNAL_COMPANY_TYPE_IDS = 'FOI:ERP_ORDER_CANCELLATION:INTERNAL_COMPANY_TYPE_IDS';

    /**
     * @var string
     */
    public const INTERNAL_STATES = 'FOI:ERP_ORDER_CANCELLATION:INTERNAL_STATES';
}
