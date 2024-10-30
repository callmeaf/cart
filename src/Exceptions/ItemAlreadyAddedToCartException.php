<?php

namespace Callmeaf\Cart\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ItemAlreadyAddedToCartException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-cart::v1.item_already_added_to_cart'), $code ?: Response::HTTP_FORBIDDEN, $previous);
    }
}

