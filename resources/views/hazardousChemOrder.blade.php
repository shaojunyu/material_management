@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                危险化学药品申购记录
                {{--<button class="layui-btn" style="margin-left: 20px" onclick="openAddForm()">添加危险化学品</button>--}}
            </blockquote>
            <table id="hazardousChemicalOrder" lay-filter="hazardousChemicalOrder">
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var form = layui.form;
        var table = layui.table;
        table.render({
            elem:$("#hazardousChemicalOrder"),
            url:'getOrders',
            cols:[[
                {field: 'id', title: '申购业务号'},
                {field: 'intro', title:'内容'},
                {field: 'statusName', title: '申购状态'},
                {field: 'created_at', title: '时间'},
                {fixed: 'right', width:150, align:'center', templet:function (d) {
                    if (d.status === "applying")
                        return '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "submitted")
                        return '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                }}
            ]]
        });
        //监听表格工具条
        table.on('tool(hazardousChemicalOrder)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定删除数据么：' + obj.data.中文名, function(index){
                    $.post('deleteHazardChemCartItem',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code === 0){
                            obj.del();
                            cartItemCount -= 1;
                            $("#cartItemCount").html(cartItemCount);
                        }
                    });
                });
            }
            else if (obj.event === 'edit'){
//                window.location.href = ;
            }
        });


    </script>
    <script type="text/html" id="toolbar">
        <div type="text/html" id="toolbarForApplying">
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </div>

    </script>

@endsection