<?php
namespace Wo;
class ResultToJson
{
  public static function success($result=null){
    self::toJson([
      'success' => true,
      'result' => $result
    ]);
  }

  public static function error($code=0, $msg=""){
    self::toJson([
      'success' => false,
      'result' => ['code' => $code, 'message' => $msg]
    ]);
  }

  private static function toJson($result){
    header('Content-Type: application/json');
    echo json_encode( $result, JSON_PRETTY_PRINT );
  }

}