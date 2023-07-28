<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

namespace App\Exception;


use Wms\Constant\ErrorCode;

class NetworkException extends AppException
{
    public function __construct($message = '', $code = ErrorCode::NETWORK_ERROR, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
