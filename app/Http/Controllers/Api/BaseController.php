<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * ajaxReturn SUCCESS with json response to front
     *
     * @param array $data 返回数据
     * @param string $msg 成功提示信息
     * @param int $status 成功状态码
     * @return string $ret 返回json
     */
    protected function _success($data=[], $msg='成功', $status=1)
    {
        $ret = [
            'data' => $data,
            'msg' => $msg,
            'status' => $status
        ];
        echo json_encode($ret);die;
    }

    /**
     * ajaxReturn ERROR with json response to front
     *
     * @param string $msg 成功提示信息
     * @param int $status 成功状态码
     * @return string $ret 返回json
     */
    protected function _error($msg='失败', $status=-1)
    {
        $ret = [
            'msg' => $msg,
            'status' => $status
        ];
        echo json_encode($ret);die;
    }
}
