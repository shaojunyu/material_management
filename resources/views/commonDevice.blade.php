@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                低值设备入库 &nbsp;(适用于单价1000元以下的仪器设备)
                <button class="layui-btn" style="margin-left: 20px" onclick="addCommonDevice()">添加</button>
                <button class="layui-btn" style="margin-left: 20px" onclick="downloadTable()">下载报表</button>
            </blockquote>
            <table id="commonDeviceTable" lay-filter="commonDeviceTable">

            </table>
        </div>
    </div>
    <div style="display: none; padding: 15px;" id="addCommonDevice">
        <form class="layui-form" action="" lay-filter="addCommonDeviceForm">
            {{ csrf_field() }}
            <div class="layui-form-mid layui-word-aux">带*为必填项</div>
            <div class="layui-form-item">
                <label class="layui-form-label">品名*</label>
                <div class="layui-input-block">
                    <input type="text" name="品名" required  lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">规格*</label>
                <div class="layui-input-block">
                    <input type="text" name="规格" required  lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">数量*</label>
                <div class="layui-input-block">
                    <input id="count" onchange="caculateTotal()" type="text" name="数量" required  lay-verify="required|number" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">单价（元）*</label>
                <div class="layui-input-block">
                    <input id="price" onchange="caculateTotal()" type="text" name="单价" required  lay-verify="required|number" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">总金额*</label>
                <div class="layui-input-block">
                    <input disabled id="total" type="text" name="总金额" required  lay-verify="required" autocomplete="off" class="layui-input" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">采购日期*</label>
                <div class="layui-input-block">
                    <input type="text" name="采购日期" required  lay-verify="required" autocomplete="off" class="layui-input" id="test1">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">采购负责人*</label>
                <div class="layui-input-block">
                    <input type="text" name="采购负责人" required  lay-verify="required" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">负责人号码*</label>
                <div class="layui-input-block">
                    <input type="text" name="负责人号码" required  lay-verify="required|phone" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">采购单位</label>
                <div class="layui-input-block">
                    <select name="采购单位" lay-verify="required">
                        <option value=""></option>
                        <option value="17000-生命学院办公室">17000-生命学院办公室</option>
                        <option value="17001-生命科学实验中心">17001-生命科学实验中心</option>
                        <option value="170111-生物医学工程系">170111-生物医学工程系</option>
                        <option value="170112-生物信息与系统生物学系">170112-生物信息与系统生物学系</option>
                        <option value="170113-生物物理与分子生理学系">170113-生物物理与分子生理学系</option>
                        <option value="170118-纳米医药与生物制药系">170118-纳米医药与生物制药系</option>
                        <option value="170119-生物化学与分子生物学系">170119-生物化学与分子生物学系</option>
                        <option value="170120-生物技术系">170120-生物技术系</option>
                        <option value="170121-遗传与发育生物学系">170121-遗传与发育生物学系</option>
                        <option value="170123-生命科学研究共享平台">170123-生命科学研究共享平台</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">供应商</label>
                <div class="layui-input-block">
                    <input type="text" name="供应商"  lay-verify="required" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="addCommonDeviceForm">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
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
            , url: 'commonDeviceList'
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
        }

        function downloadTable() {
            var checkStatus = table.checkStatus('commonDeviceTable');
            if (checkStatus.data.length === 0) {
                layer.msg("请至少选择一行")
                return;
            }
            console.log(checkStatus.data);
        }


    </script>
@endsection