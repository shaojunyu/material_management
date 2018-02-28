@extends('layouts.admin')
@section('main-body')
    <style>
        .layui-form-label{
            width: 120px;
        }
    </style>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <img src="images/radioactive2.png">
                <h2 style="display: inline">放射性同位素申购管理</h2>
            </blockquote>

            {{--待审核--}}
            <div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>待审核</legend>
                </fieldset>
                <table id="submittedRadioactiveTable" lay-filter="submittedRadioactiveTable">
                </table>
            </div>

            {{--审核通过--}}
            <div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>已审核完成</legend>
                </fieldset>
                <table id="approvedRadioactiveTable" lay-filter="approvedRadioactiveTable">
                </table>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        var form = layui.form;
        var table = layui.table;
        table.render({
            elem: '#approvedRadioactiveTable'
            , url: 'approvedRadioactive'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'}
                ,{field: 'id', title: '编号'}
                , {field: '放射性同位素名称', title: '放射性同位素'}
                , {field: '射线装置名称', title: '射线装置名称'}
                , {field: '实验室负责人', title: '实验室负责人'}
                , {field: '负责人手机', title: '负责人手机'}
                , {field: '保存地点及条件', title: '保存地点及条件'}
                ,{field: 'approved_at',title: '状态', templet:function (d) {
                    if(d.approved_at){
                        return "已审批："+d.approved_at;
                    }else if (d.status === "applying"){
                        return "草稿，尚未提交审批"
                    }else if(d.status === "submitted"){
                        return "已提交，等待审批"
                    }
                }}
                , {fixed: 'right', width:200, align:'center', templet:function (d) {
                    if (d.status === "applying")
                        return '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "submitted")
                        return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="approve">通过</a>\n' +
                            '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "done")
                        return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="download">下载报表</a>\n' +
                            '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n';
                }}
            ]]
        });
        table.render({
            elem: '#submittedRadioactiveTable'
            , url: 'submittedRadioactive'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'}
                ,{field: 'id', title: '编号'}
                , {field: '放射性同位素名称', title: '放射性同位素'}
                , {field: '射线装置名称', title: '射线装置名称'}
                , {field: '实验室负责人', title: '实验室负责人'}
                , {field: '负责人手机', title: '负责人手机'}
                , {field: '保存地点及条件', title: '保存地点及条件'}
                ,{field: 'approved_at',title: '状态', templet:function (d) {
                    if(d.approved_at){
                        return "已审批："+d.approved_at;
                    }else if (d.status === "applying"){
                        return "草稿，尚未提交审批"
                    }else if(d.status === "submitted"){
                        return "已提交，等待审批"
                    }
                }}
                , {fixed: 'right', width:200, align:'center', templet:function (d) {
                    if (d.status === "applying")
                        return '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "submitted")
                        return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="approve">通过</a>\n' +
                            '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "done")
                        return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="download">下载报表</a>\n' +
                            '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n';
                }}
            ]]
        });

        //监听表格工具条
        table.on('tool(submittedRadioactiveTable)', function(obj){
            var data = obj.data;
            if(obj.event === 'view'){
                $.post('radioactiveDetail',{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                } ,function(str){
                    layer.open({
                        type: 1,
                        area:['1000px'],
                        content: str ,
                        title: '详情',
                    });
                });

            } else if(obj.event === "edit"){
                $.post("editRadioactive",{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                },function (str) {
                    layer.open({
                        type:1,
                        title:'编辑放射性物质申购',
                        area:['1000px'],
                        content:str
                    });
                });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除申购数据么，编号：' + obj.data.id, function(index){
                    $.post('deleteRadioactive',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code == 0){
                            table.reload("submittedRadioactiveTable");
                            table.reload("approvedRadioactiveTable");
                        }
                    });
                });
            } else if(obj.event === 'download'){
                var url = 'downloadRadioactiveForm?id='+obj.data.id;
                window.open(url);
            } else if(obj.event === 'approve'){
                layer.confirm('确定审核通过申购数据么，编号：' + obj.data.id, function(index){
                    $.post('approveRadioactive',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code == 0){
                            table.reload("submittedRadioactiveTable");
                            table.reload("approvedRadioactiveTable");
                        }
                    });
                });
            }
        });

        //监听表格工具条
        table.on('tool(approvedRadioactiveTable)', function(obj){
            var data = obj.data;
            if(obj.event === 'view'){
                $.post('radioactiveDetail',{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                } ,function(str){
                    layer.open({
                        type: 1,
                        area:['1000px'],
                        content: str ,
                        title: '详情',
                    });
                });

            } else if(obj.event === "edit"){
                $.post("editRadioactive",{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                },function (str) {
                    layer.open({
                        type:1,
                        title:'编辑放射性物质申购',
                        area:['1000px'],
                        content:str
                    });
                });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除申购数据么，编号：' + obj.data.id, function(index){
                    $.post('deleteRadioactive',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code == 0){
                            table.reload("submittedRadioactiveTable");
                            table.reload("approvedRadioactiveTable");
                        }
                    });
                });
            } else if(obj.event === 'download'){
                var url = 'downloadRadioactiveForm?id='+obj.data.id;
                window.open(url);
            } else if(obj.event === 'approve'){
                layer.confirm('确定审核通过申购数据么，编号：' + obj.data.id, function(index){
                    $.post('approveRadioactive',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code == 0){
                            table.reload("submittedRadioactiveTable");
                            table.reload("approvedRadioactiveTable");
                        }
                    });
                });
            }
        });
    </script>
@endsection