<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi;

class CollaborativeCartsRestApiConfig
{
    /**
     * @var string
     */
    public const RESOURCE_COLLABORATIVE_CARTS = 'collaborative-carts';

    /**
     * @var string
     */
    public const CONTROLLER_COLLABORATIVE_CARTS = 'collaborative-carts-resource';

    /**
     * @var string
     */
    public const ACTION_COLLABORATIVE_CARTS_POST = 'post';

    /**
     * @var string
     */
    public const ACTION_CLAIM = 'claim';

    /**
     * @var string
     */
    public const ACTION_RELEASE = 'release';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CART_ID_MISSING = '4500';

    /**
     * @var string
     */
    public const RESPONSE_CODE_INVALID_ACTION = '4501';

    /**
     * @var string
     */
    public const RESPONSE_CODE_NOT_CLAIMED = '4502';

    /**
     * @var string
     */
    public const RESPONSE_CODE_NOT_RELEASED = '4503';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_CART_ID_MISSING = 'Cart id is missing.';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_INVALID_ACTION = 'Invalid value for action.';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_NOT_CLAIMED = 'Cart could not be claimed.';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_NOT_RELEASED = 'Cart could not be released.';
}
