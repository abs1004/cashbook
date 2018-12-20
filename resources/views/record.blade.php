@extends('layouts.app')

@section('content')
    <!-- Create record Form... -->
    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    {{--@include('common.errors')--}}
    <!-- New Task Form -->
        <form action="{{route('record.store')}}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Task Name -->
            <div class="form-group">
                <div class="mt-8">
                    <label class="col-sm-2 control-label">类型</label>
                    <div class="col-sm-10">
                        <select name="category_id" id="category_id" class="form-control" autocomplete="off">
                            @foreach ($categorys as $category)
                                <option value="{{$category->id}}" {{$category->id==1 ? 'selected' : '' }}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-8">
                    <label class="col-sm-2 control-label">名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" maxlength="10" id="record-name" class="form-control" placeholder="费用名称">
                    </div>
                </div>
                <div class="mt-8">
                    <label class="col-sm-2 control-label">金额</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" min="0.00" name="money" id="record-money" class="form-control" placeholder="金额">
                    </div>
                </div>
                <br />
                <button type="submit" class="col-xs-10 col-xs-offset-1 btn btn-success ">
                    <i class="fa fa-plus"></i> 添加记录
                </button>

            </div>
        </form>
    </div>

    <!-- Current records -->
    <div class="panel panel-default container">
        <div class="panel-heading row">
            <form action="{{route('search')}}" method="GET">
                <div class="col-xs-4">
                    <select name="input_year" id="input_year" class="form-control">
                        @foreach ($years as $year)
                            <option value="{{$year}}" {{$year==$selected_year ? 'selected' : '' }}>{{$year}}年</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-4">
                    <select name="input_month" id="input_month" class="form-control">
                        <option value="0" {{$selected_month==0 ? 'selected' : '' }}>所有月</option>
                        @foreach ($months as $month)
                            <option value="{{$month}}" {{$month==$selected_month ? 'selected' : '' }}>{{$month}}月</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-4">
                    <button id="btn_record_search" class="btn btn-info">查询</button>
                </div>
            </form>
        </div>

    @if (count($records) > 0)
        <div class="panel-body">
            <div style="text-align:right;width:100%;color:red;">
                总计: {{$sum}} 元
            </div>
            <ul id="record_list">
                @foreach ($records as $key=>$record)
                    <li class="li-edit" data-rid="{{$record->id}}" data-toggle="modal" data-target="#editItem">
                        {{$record->created_at}}<br />
                        {{$record->money}} 元（{{$record->category_name}}）<br />
                        {{ $record->name }}<br />
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <!-- Edit Task Form -->

    <!-- 模态框 - 编辑商品 -->
    <div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="goodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="goodModalLabel">编辑</h4>
                </div>
                <div class="modal-body">
                    <div  class="form-horizontal">
                        <input type="text" hidden name="id" id="edit_id" value="0">
                        <div class="form-group">
                            <div class="mt-8">
                                <label class="col-sm-2 control-label">类型</label>
                                <div class="col-sm-10">
                                    <select name="category_id" id="edit_cid" class="form-control" autocomplete="off">
                                        @foreach ($categorys as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mt-8">
                                <label class="col-sm-2 control-label">用途</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" id="edit_name" class="form-control" placeholder="费用名称">

                                </div>
                            </div>
                            <div class="mt-8">
                                <label class="col-sm-2 control-label">金额</label>
                                <div class="col-sm-10">
                                    <input type="text" name="money" id="edit_money" class="form-control" placeholder="金额">
                                </div>
                            </div>
                            <br />
                            <button id="edit_save" class="col-xs-offset-1 col-xs-10 btn btn-success">
                                保存
                            </button>

                        </div>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <script>
        window.onload = function(){
            var domain = "{{$_SERVER['HTTP_HOST']}}";

            $(".li-edit").on('click',function editClick() {
                console.log(domain);

                var tar  = $(this);
                var rid = tar.attr('data-rid');
                console.log("id="+rid);

                $.ajax({
                    url: "/api/record/ajaxShow",
                    data: {id: rid},
                    contentType: "application/json",
                    type: 'GET',
                    dataType: 'json',
                    // headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (res) {
                        console.log(res);
                        if (res.status == 1) {
                            console.log(res.data);
                            $("#edit_id").val(res.data.id);
                            $("#edit_money").val(res.data.money);
                            $("#edit_name").val(res.data.name);
                            $("#edit_cid").find("option[value="+res.data.category_id+"]").attr("selected",true);
                        } else {
                            alert(res.msg);
                        }
                    },
                });
            });

            $("#edit_save").on('click',function editClick() {
                var id = $("#edit_id").val();
                var money = $("#edit_money").val();
                var name = $("#edit_name").val();
                var cid = $("#edit_cid").val();
                $.ajax({
                    url: "/api/record/ajaxSave",
                    data: {id: id, money: money, name: name, category_id: cid},
                    contentType: "application/json",
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        if (res.status == 1) {
                            console.log(res.data);
                            $("#editItem").hide();
                            alert('修改成功');
                            window.location.href = '/';
                        } else {
                            alert(res.msg);
                        }
                    },
                });
            });

        }
    </script>
@endsection
