<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

namespace App\Exception;


use Wms\Constant\ErrorCode;
use Wms\Exception\WmsException;

class AppException extends WmsException
{

    public function __construct($message, $code = ErrorCode::SYSTEM_ERROR, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
