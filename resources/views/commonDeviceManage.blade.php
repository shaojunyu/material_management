@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <h2 style="display: inline">低值设备管理</h2>
                <button class="layui-btn" style="margin-left: 20px" onclick="downloadTable()">下载报表</button>
            </blockquote>
            <table id="commonDeviceTable" lay-filter="commonDeviceTable">

            </table>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/html" id="barDemo">
        <!--<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>-->
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
            elem: '#commonDeviceTable'
            , url: 'allCommonDevices'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'}
                , {field: '品名', title: '品名'}
                , {field: '规格', title: '规格'}
                , {field: '数量', title: '数量'}
                , {field: '单价', title: '单价'}
                , {field: '总金额', title: '总金额'}
                , {field: '采购负责人', title: '采购负责人'}
                , {field: '负责人号码', title: '负责人号码'}
                , {field: '采购单位', title: '采购单位'}
                , {field: '采购日期', title: '采购日期'}

                , {fixed: 'right', width: 150, align: 'center', toolbar: '#barDemo'}
            ]]
        });

        //监听表格工具条
        table.on('tool(commonDeviceTable)', function(obj){
            var data = obj.data;
            if(obj.event === 'view'){
//                console.log(data)
//                layer.msg( data.id);
                $.post('commonDeviceDetail',{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                } ,function(str){
                    layer.open({
                        type: 1,
                        content: str ,
                        title: '详情',
                    });
                });

            } else if(obj.event === 'del'){
                layer.confirm('确定删除数据么：' + obj.data.品名, function(index){
                    $.post('deleteCommonDevice',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code == 0){
                            table.reload("commonDeviceTable")
                        }
                    });
                });
            }
        });

        form.on('submit(addCommonDeviceForm)', function(data){//on 绑定submit button的filter
            console.log(data) //被执行事件的元素DOM对象，一般为button对象
            console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            $.post('addCommonDevice',data.field,function (d) {
                if(d.code == 0){
                    layer.closeAll();
                    table.reload("commonDeviceTable");
                }
                layer.msg(d.message);
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

        function addCommonDevice() {
            layer.open({
                type:1,
                content:$('#addCommonDevice'),
                title:'添加低值设备'
            })
        }

        function caculateTotal() {
            var price = $("#price").val()
            var count = $("#count").val()
            $("#total").val(price*count)
            if(price * count){
//                layer.alert("");
            }
        }

        function downloadTable() {

        }


    </script>
@endsection