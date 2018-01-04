@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <h2 style="display: inline">普通试剂管理</h2>
                {{--<button class="layui-btn" style="margin-left: 20px" onclick="addCommonChem()">添加</button>--}}
                <button class="layui-btn" style="margin-left: 20px" onclick="downloadTable()">下载报表</button>
            </blockquote>
            <table id="commonChemTable" lay-filter="commonChemTable">

            </table>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="view">查看</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
        var form = layui.form;
        var table = layui.table;
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#test1' //指定元素
        });

        table.render({
            elem: '#commonChemTable'
            , url: 'allCommonChem'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'}
                , {field: '试剂名称', title: '试剂名称'}
                , {field: '规格', title: '规格'}
                , {field: '数量', title: '数量'}
                , {field: '单价', title: '单价'}
                , {field: '总金额', title: '总金额'}
                , {field: '申购人姓名', title: '申购人姓名'}
                , {fixed: 'right', width: 150, align: 'center', toolbar: '#barDemo'}
            ]]
        });

        //监听表格工具条
        table.on('tool(commonChemTable)', function (obj) {
            var data = obj.data;
            if (obj.event === 'view') {
//                console.log(data)
//                layer.msg( data.id);
                $.post('commonChemDetail', {
                    id: obj.data.id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function (str) {
                    layer.open({
                        type: 1,
                        content: str,
                        title: '详情',
                    });
                });

            } else if (obj.event === 'del') {
                layer.confirm('确定删除数据么：' + obj.data.试剂名称, function (index) {
                    $.post('deleteCommonChem', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("commonChemTable")
                        }
                    });
                });
            } else if (obj.event === 'edit') {
                $.post('editHazardChem', {
                    id: obj.data.id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function (str) {
                    $("#editDiv").html(str);
                    layer.open({
                        type: 1,
                        content: $("#editDiv"),
                        title: '更新化学品信息',
                        maxWidth: 500
                    });
                });
            }
        });


        function downloadTable() {

        }
    </script>
@endsection