@extends('layouts.admin')
@section('main-body')
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <blockquote class="layui-elem-quote">
            普通试剂入库
            <button class="layui-btn" style="margin-left: 20px" onclick="addCommonChem()">添加</button>
            <button class="layui-btn" style="margin-left: 20px" onclick="downloadTable()">下载报表</button>
        </blockquote>
        <table id="commonChemTable" lay-filter="commonChemTable">

        </table>
    </div>
</div>
<div style="display: none; padding: 15px;" id="addCommonChem">
    <form class="layui-form" action="" lay-filter="addCommonChemForm">
        {{ csrf_field() }}
        <div class="layui-form-mid layui-word-aux">带*为必填项</div>
        <div class="layui-form-item">
            <label class="layui-form-label">试剂名称*</label>
            <div class="layui-input-block">
                <input type="text" name="试剂名称" id="nameInput" required onchange="checkIfHazard()" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">规格*</label>
            <div class="layui-input-block">
                <input type="text" name="规格" required lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数量*</label>
            <div class="layui-input-block">
                <input id="count" onchange="caculateTotal()" type="text" name="数量" required lay-verify="required|number"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">单价（元）*</label>
            <div class="layui-input-block">
                <input id="price" onchange="caculateTotal()" type="text" name="单价" required lay-verify="required|number"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">总金额*</label>
            <div class="layui-input-block">
                <input disabled id="total" type="text" name="总金额" required lay-verify="required" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申报日期*</label>
            <div class="layui-input-block">
                <input type="text" name="申报日期" required lay-verify="required" autocomplete="off" class="layui-input"
                       id="test1">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申购人姓名*</label>
            <div class="layui-input-block">
                <input type="text" name="申购人姓名" required lay-verify="required" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申购人号码*</label>
            <div class="layui-input-block">
                <input type="text" name="申购人号码" required lay-verify="required|phone" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申购单位</label>
            <div class="layui-input-block">
                <select name="申购单位" lay-verify="required">
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
                <input type="text" name="供应商" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">供应商电话</label>
            <div class="layui-input-block">
                <input type="text" name="供应商电话" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">经费编号</label>
            <div class="layui-input-block">
                <input type="text" name="经费编号" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">经费名称</label>
            <div class="layui-input-block">
                <input type="text" name="经费名称" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="addCommonChemForm">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
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
        , url: 'commonChemList'
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

    form.on('submit(addCommonChemForm)', function (data) {//on 绑定submit button的filter
        var text = $("#nameInput").val();
        if (!text) {
            return;
        }
        $.post('checkIfHazard', {
            chem: text,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function (d) {
            if (d.code != 0) {
                layer.confirm(text + "是危化品，无法添加！请到危化品页面申购！", {
                    btn: ['去危化品页面', '关闭'] //可以无限个按钮
                }, function (index) {
                    window.location.href = "./HazardousChemical?search=" + text;
                }, function (index) {
                });
            }
            else {
                $.post('addCommonChem', data.field, function (d) {
                    if (d.code == 0) {
                        layer.closeAll();
                        table.reload("commonChemTable");
                    }
                    layer.msg(d.message);
                });
            }

        });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });

    function addCommonChem() {
        layer.open({
            type: 1,
            content: $('#addCommonChem'),
            title: '添加普通试剂'
        })
    }

    function caculateTotal() {
        var price = $("#price").val()
        var count = $("#count").val()
        $("#total").val(price * count)
    }

    function downloadTable() {
        var checkStatus = table.checkStatus('commonChemTable');
        if (checkStatus.data.length === 0) {
            layer.msg("请至少选择一行");
            return;
        }
        var ids = [];
        checkStatus.data.forEach(function (item) {
            ids.push(item.id)
        });
        var url = 'downloadDeviceForm?ids=' + encodeURI(JSON.stringify(ids))
        window.open(url);
//        console.log(encodeURI(ids));
    }

    function checkIfHazard() {
        var text = $("#nameInput").val()
        if (!text) {
            return;
        }
//            console.log(text);
        $.post('checkIfHazard', {
            chem: text,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function (d) {
            if (d.code != 0) {
                layer.confirm(text + "是危化品，无法添加！请到危化品页面申购！", {
                    btn: ['去危化品页面', '关闭'] //可以无限个按钮
                }, function (index) {
//                        console.log("1111");
                    window.location.href = "./HazardousChemical?search=" + text;
                }, function (index) {

                });
//                    layer.alert(text + "是危化品，无法添加！请到危化品页面申购！");
                return false;
            }
            else {
                return true;
            }
        });

    }


</script>
@endsection