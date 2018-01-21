<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 23:26
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(Exception $e)
    {
        // TODO: 添加全局异常处理逻辑
        if($e instanceof BaseException){
            $this->code=$e->code;
            $this->msg=$e->msg;
            $this->errorCode=$e->errorCode;
        }
        else{
            if(config('app_debug')){
                return parent::render($e);
            }
            else{
                $this->code=500;
                $this->msg='服务器内部错误';
                $this->errorCode=999;
                //TODO:添加服务器内部错误日志
                $this->recordErrorLog($e);
            }
        }

        $result=[
            'msg'=>$this->msg,
            'error_code'=>$this->errorCode,
            'request_url'=>Request::instance()->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(Exception $e){
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);
        Log::record($e->getMessage(), 'error');
    }
}