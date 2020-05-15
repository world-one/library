<?php
namespace Wo;
use Wo\ResultToJson;
class Utils{

  public static function paramsCheck($params=[], $keys = [], $errCode = -1)
  {
    $return = new ResultToJson();

    if(empty( $keys )) $return->error( $errCode, 'Empty Keys' );

    $notExist = '';
    $emptyValue = '';

    foreach( $keys as $key ){
      if(!array_key_exists( $key, $params )) {
          $notExist .= '['.$key.']';
      }else{
        $value = trim($params[$key]);
        if(empty($value)) $emptyValue .= '['.$key.']';
      }
    } 
    
    if(!empty($notExist)) $return->error( $errCode, 'require parameter '.$notExist.' not exist' );
    if(!empty($emptyValue)) $return->error( $errCode, 'require parameter '.$emptyValue.' value empty' );
    
    return true;
    
  }
}