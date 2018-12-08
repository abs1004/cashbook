<?php

namespace App\Http\Controllers\Api;

use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecorderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json('api接口 - 消费记录');
    }

    /**
     * Ajax show
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxShow(Request $request){
        $record = DB::table('records as r')
            ->join('categorys as c', 'r.category_id', '=', 'c.id')
            ->select('r.id as id', 'r.name as name', 'r.money as money', 'c.id as category_id', 'c.name as category_name')
            ->where('r.id',$request->id)
            ->get();
        if($record){
            $this->_success($record[0]);
        }else{
            $this->_error('获取数据失败');
        }
    }
    /**
     * Ajax save
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function ajaxSave(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'money' => 'required|max:6',
            'category_id' => 'required|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg'=>$validator,'status'=>-1]);
        }
        $rst = DB::table('records')
            ->where('id',$request->id)
            ->update(['name'=>$request->name, 'money'=>$request->money, 'category_id'=>$request->category_id]);
        if($rst){
            $this->_success('保存成功');
        }else{
            $this->_error('保存失败');
        }
    }
}
