<?php 
class Common
{
    const CODE_ERROR = 0;
    const CODE_OK    = 1;
    
    static function getCodeMessage()
    {
        return [
            CODE_OK     => '数据正确!',
            CODE_ERROR  => '数据返回有误!',
        ];
    }
    
}


?>