<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

namespace App\Exception;


use Wms\Constant\ErrorCode;

class AuthException extends AppException
{
    public function __construct($message = '', $code = ErrorCode::NO_PERMISSION, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
