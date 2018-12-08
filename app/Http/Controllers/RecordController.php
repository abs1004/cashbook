<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Record;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{

    private $user_id = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$this->user_id){
            $this->user_id = Auth::user()->id;
        }

        $categorys = Category::orderBy('id','desc')->get();
        $selected_year = date('Y');
        $selected_month = 0;

        $years = [];$months = [];
        for($i=1; $i<=12; $i++){
            array_push($months,$i);
        }
        for($y=$selected_year-4; $y<=$selected_year; $y++){
            array_push($years,$y);
        }

        $sum = round( $this->sumMoney($this->user_id, $selected_year), 2 ) ;

        $records = $this->_getRecords($this->user_id, $selected_year);

        return view('record', compact("categorys", "sum", "records", "selected_year", "selected_month", "months",
            "years") );
    }

    /**
     * search a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if(!$this->user_id){
            $this->user_id = Auth::user()->id;
        }
        $selected_year = $request->input_year ? : date('Y');
        $selected_month = $request->input_month ? : 0;

        $categorys = Category::orderBy('id','asc')->get();
        $years = [];$months=[];
        for($i=1; $i<=12; $i++){
            array_push($months,$i);
        }
        for($y=$selected_year-4; $y<=$selected_year; $y++){
            array_push($years,$y);
        }
        $sum = round( $this->sumMoney($this->user_id, $selected_year,$selected_month), 2 ) ;

        $records = $this->_getRecords($this->user_id, $selected_year,$selected_month);

        return view('record', compact("categorys", "sum", "records", "selected_year", "selected_month", "months", "years") );
    }

    private function sumMoney($user_id,  $inputYear, $inputMonth=null){

        $sum = DB::table('records')
            ->where('user_id',$user_id)
            ->whereYear('created_at', $inputYear)
            ->when($inputMonth, function ($query) use ($inputMonth) {
                return $query->whereMonth('created_at', $inputMonth);
            })
            ->sum('money');
        return $sum;
    }
    private function _getRecords($user_id, $inputYear , $inputMonth=null){

        $whereRecords = [
            ['r.user_id','=', $user_id],
        ];

        $records = DB::table('records as r')
            ->join('categorys as c', 'r.category_id', '=', 'c.id')
            ->select('r.*', 'c.name as category_name')
            ->where($whereRecords)
            ->whereYear('r.created_at', $inputYear)
            ->when($inputMonth, function ($query) use ($inputMonth) {
                return $query->whereMonth('r.created_at', $inputMonth);
            })
            ->orderBy('r.created_at', 'desc')
//            ->offset(0)
//            ->limit(15)
            ->get();
        return $records;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        $record = new Record;
        $record->name = $request->name;
        $record->money = $request->money;
        $record->category_id = $request->category_id;
        $record->user_id = isset(Auth::user()->id) ? Auth::user()->id : 0 ; //TODO  cookie
        $record->save();

        return redirect('/');
    }

    /**
     * Display the specified resource ajax=modal
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Record::findOrFail($id)->delete();
    }
}
