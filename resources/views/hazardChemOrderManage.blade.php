@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <h2>危险化学药品申购管理</h2>
                {{--<button class="layui-btn" style="margin-left: 20px" onclick="openAddForm()">添加危险化学品</button>--}}
            </blockquote>
            <table id="allHazardousChemicalOrders" lay-filter="allHazardousChemicalOrders">
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var form = layui.form;
        var table = layui.table;
        var ordersTable = table.render({
            elem:$("#allHazardousChemicalOrders"),
            url:'allHazardousChemicalOrders',
            page: true,
            cols:[[
                {field: 'id', title: '申购业务号'},
                {field: '申购人姓名', title: '申购人'},
                {field: 'fuzeren', title: '负责人'},
                {field: 'intro', title:'内容'},
                {field: 'status', title: '申购状态', templet:function (d) {
                    if (d.status === "submitted")
                        return '等待审核';
                    if (d.status === "done")
                        return '审核通过';
                }},
                {field: 'created_at', title: '时间'},
                {fixed: 'right', width:280, align:'center', templet:function (d) {
                    if (d.status === "applying")
                        return '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "submitted")
                        return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="pass">审核通过</a>\n' +
                            '<a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="download">下载报表</a>\n' +
                            '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "done")
                        return '<a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="download">下载报表</a>\n' +
                            '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';

                    }}
            ]]
        });
        //监听表格工具条
        table.on('tool(allHazardousChemicalOrders)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定删除数据么：' + obj.data.id+"订单", function(index){
                    $.post('deleteOrder',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code === 0){
                            obj.del();
                        }
                    });
                });
            }
            else if (obj.event === 'edit'){
                window.location.href = 'editOrder?orderId='+obj.data.id;
            }else if(obj.event === 'view'){
                $.get('viewOrderDetail?order_id='+obj.data.id,function (d) {
                    layer.open({
                        type:1,
                        area:'1200px',
                        content:d
                    });
                });
            }else if(obj.event === 'pass'){
                layer.confirm('确定审核通过该业务么？ <br>业务号:'+obj.data.id,function (index) {
                    $.ajax({
                        type: "POST",
                        url: "passOrder",
                        contentType: "application/json; charset=utf-8",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: JSON.stringify({order_id:obj.data.id}),
                        success: function (d) {
                            ordersTable.reload();
                            layer.close(index);
                            layer.msg(d.message, {icon: 1,time:2*1000});
                        }
                    });
                });
            }else if(obj.event === 'download'){
                var url = 'downloadOrderForm?order_id='+obj.data.id;
                window.open(url);
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