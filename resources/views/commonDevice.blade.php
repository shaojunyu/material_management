@extends('layouts.admin')
@section('main-body')
    <style>
        .layui-elem-quote-red {
            margin-bottom: 10px;
            padding: 15px;
            line-height: 22px;
            border-radius: 0 2px 2px 0;
            background-color: #f2f2f2;
            border-left: 5px solid #ff0000;
        }
    </style>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <img src="images/device2.png">
                <h2 style="display: inline">低值设备入库 &nbsp;(适用于单价1000元以下的仪器设备)</h2>
                <button class="layui-btn" style="margin-left: 20px" onclick="showHistory()">显示历史批次</button>
                <button class="layui-btn" style="margin-left: 20px" onclick="addCommonDevice()">添加</button>
                <button class="layui-btn" style="margin-left: 20px" onclick="downloadTable()">合并到统一批次</button>
                <button class="layui-btn" style="margin-left: 20px" id="uploadButton">一键导入</button>
                <a style="margin-left: 20px" href="docs/低值设备导入模板.xlsx">下载模板</a>
            </blockquote>
            <table id="commonDeviceTable" lay-filter="commonDeviceTable">

            </table>
            <div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>历史批次</legend>
                </fieldset>
                <table id="commonDeviceHistoryTable" lay-filter="commonDeviceHistoryTable">
                </table>
            </div>
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
                , {field: '采购单位', title: '采购单位',width:300}
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
            if ($("#price").val() >= 1000){
                layer.alert("低值设备单价不可超过1000元！");
                return false;
            }
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
            var price = $("#price").val();
            var count = $("#count").val();
            if (price >= 1000){
                layer.alert("低值设备单价不可超过1000元！");
            }
            $("#total").val(price*count)
        }

        function downloadTable() {
            var checkStatus = table.checkStatus('commonDeviceTable');
            if (checkStatus.data.length === 0) {
                layer.msg("请至少选择一行")
                return;
            }
            var ids = [];
            var total = 0;
            var confirm = "<h3>以下物品会打包成一个批次，请确认!<br><ul>";
            checkStatus.data.forEach(function (item) {
                ids.push(item.id);
                confirm += "<li><span class=\"layui-badge-dot layui-bg-black\"></span>&nbsp;" + item.品名 + "</li>";
                total += item.总金额;
            });
            confirm += "</ul>";
            if (total >= 100000) {
                confirm += "<blockquote class=\"layui-elem-quote-red\">该批次总价为：<h2>" + total + "元</h2><br>"
                    + "根据学院规定，单批次价格≥10万元时，需要实验室与设备管理处验收观察员现场验收，签字。请知悉！</blockquote></h3>"
            } else if (total >= 50000) {
                confirm += "<blockquote class=\"layui-elem-quote-red\">该批次总价为：<h2>" + total + "元</h2><br>"
                    + "根据学院规定，单批次价格≥5万元时，需要单位分管领导现场验收，签字。请知悉！</blockquote></h3>"
            }
            else if (total >= 10000) {
                confirm += "<blockquote class=\"layui-elem-quote-red\">该批次总价为：<h2>" + total + "元</h2><br>"
                    + "根据学院规定，单批次价格≥1万元时，需要单位设备管理员现场验收，签字。请知悉！</blockquote></h3>"
            } else {
                confirm += "<blockquote class=\"layui-elem-quote-red\">该批次总价为：<h2>" + total + "元</h2><br>"
                    + "</blockquote></h3>"
            }
            var url = 'downloadCommonDeviceForm?ids=' + encodeURI(JSON.stringify(ids));
            layer.confirm(confirm, function (index) {
                layer.close(index);
                window.open(url);
                setTimeout(function () {
                    table.reload("commonDeviceTable");
                    table.reload("commonDeviceHistoryTable");
                },2000);
            });
        }
        
        function showHistory() {
            layer.load();
            table.render({
                elem: '#commonDeviceHistoryTable'
                , url: 'commonDeviceHistoryList'
                , limit: 20
                , page: true //开启分页
                , cols: [[ //表头
                    {type: 'checkbox'}
                    , {field: 'id', title: '批次编号', width:100}
                    , {field: 'intro', title: '内容'}
                    , {field: '总金额', title: '总金额(￥)',width:100}
                    , {field: 'created_at', title: '创建时间'}
                    , {field: 'status', title: '状态',width:150,templet: function (d){
                        if(d.status === 'submitted')
                            return "已提交，等待审核";
                        if (d.status === "done")
                            return "已完成审核";
                    }}
                    , {
                        fixed: 'right', align: 'center', templet: function (d) {
                            if (d.status === "applying")
                                return '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>\n' +
                                    '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                            if (d.status === "submitted")
                                return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="download">下载报表</a>\n' +
                                    '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n' +
                                    '<a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="resolve">解除批次</a>\n' +
                                    '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                            if (d.status === "done")
                                return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="download">下载报表</a>\n' +
                                    '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n';
                        }
                    }
                ]],
                done: function () {
                    layer.closeAll();
                }
            });
        }

        //上传
        var upload = layui.upload; //得到 upload 对象
        upload.render({
            elem: '#uploadButton',
            url: 'uploadTable',
            method: 'post',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                type: 'commonDevice'
            },
            exts: 'xlsx',
            done: function () {
                layer.msg('导入成功', {
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function () {
                    window.location.reload();
                });
            },
            error: function () {
                layer.msg('导入错位，请检查数据格式，重试！', {
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function () {
                    window.location.reload();
                });
            }
        });

    </script>
    {{--详情模板--}}
    <div id="batchCommonDeviceDetail" hidden style="padding: 10px;">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>批次编号：@{{ id }} &nbsp;| &nbsp;总金额：@{{ total }}</legend>
        </fieldset>
        <table class="layui-table">
            <thead>
            <tr>
                <th>品名</th>
                <th>规格</th>
                <th>数量</th>
                <th>单价</th>
                <th>小计</th>
                <th>申报日期</th>
                <th>负责人</th>
                <th>负责人号码</th>
                <th>采购单位</th>
                <th>供应商</th>
                {{--<th>供应商电话</th>--}}
                {{--<th>经费编号</th>--}}
                {{--<th>经费名称</th>--}}
            </tr>
            </thead>
            <tbody>
            <tr v-for="device in devices">
                <td>@{{ device.品名 }}</td>
                <td>@{{ device.规格 }}</td>
                <td>@{{ device.数量 }}</td>
                <td>@{{ device.单价 }}</td>
                <td>@{{ device.总金额}}</td>
                <td>@{{ device.采购日期}}</td>
                <td>@{{ device.采购负责人 }}</td>
                <td>@{{ device.负责人号码 }}</td>
                <td>@{{ device.采购单位 }}</td>
                <td>@{{ device.供应商 }}</td>
                {{--<td>@{{ device.供应商电话 }}</td>--}}
                {{--<td>@{{ device.经费编号 }}</td>--}}
                {{--<td>@{{ device.经费名称 }}</td>--}}
            </tr>
            </tbody>
        </table>
    </div>
    <script>
        var app = new Vue({
            el: '#batchCommonDeviceDetail',
            data: {
                devices: [],
                id:'',
                total:0
            }
        });
        //监听表格工具条
        table.on('tool(commonDeviceHistoryTable)', function (obj) {
            var data = obj.data;
//            console.log(data);
            if (obj.event === 'view') {
                app.devices = data.devices;
                app.id = data.id;
                app.total = data.总金额;
                layer.open({
                    type: 1,
                    content: $("#batchCommonDeviceDetail"),
                    title: '批次详情',
                    area: ['1300px','700px']
                });
            } else if (obj.event === 'del') {
                layer.confirm('确定删除该批次数据么？批次号：' + obj.data.id, function (index) {
                    $.post('batchDeleteCommonDevice', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("commonDeviceHistoryTable")
                        }
                    });
                });
            } else if (obj.event === 'download') {
                var ids = [];
                var total = 0;
                var confirm = "<h3>您将下载该批次的申报文件，请确认!<br>";
                confirm += "<h3>批次号："+data.id+"<br><ul>";
                data.devices.forEach(function (item) {
                    ids.push(item.id);
                    confirm += "<li><span class=\"layui-badge-dot layui-bg-black\"></span>&nbsp;" + item.品名 + "</li>";
                    total += item.总金额;
                });
                confirm += "</ul>";
                if (total >= 100000) {
                    confirm += "<blockquote class=\"layui-elem-quote-red\">该批次总价为：<h2>" + total + "元</h2><br>"
                        + "根据学院规定，单批次价格≥10万元时，需要实验室与设备管理处验收观察员现场验收，签字。请知悉！</blockquote></h3>"
                } else if (total >= 50000) {
                    confirm += "<blockquote class=\"layui-elem-quote-red\">该批次总价为：<h2>" + total + "元</h2><br>"
                        + "根据学院规定，单批次价格≥5万元时，需要单位分管领导现场验收，签字。请知悉！</blockquote></h3>"
                }
                else if (total >= 10000) {
                    confirm += "<blockquote class=\"layui-elem-quote-red\">该批次总价为：<h2>" + total + "元</h2><br>"
                        + "根据学院规定，单批次价格≥1万元时，需要单位设备管理员现场验收，签字。请知悉！</blockquote></h3>"
                } else {
                    confirm += "<blockquote class=\"layui-elem-quote-red\">该批次总价为：<h2>" + total + "元</h2><br>"
                        + "</blockquote></h3>"
                }
                var url = 'batchDownloadCommonDeviceForm?id=' + data.id;
                layer.confirm(confirm, function (index) {
                    window.open(url);
                    table.reload("commonDeviceTable");
                    layer.close(index);
                });
            }else if (obj.event === "resolve"){//分解批次
                var ids = [];
                var total = 0;
                var confirm = "<h3>您将解除该批次，请确认!<br>";
                confirm += "<h3>批次号：" + data.id + "<br><ul>";
                data.chemicals.forEach(function (item) {
                    ids.push(item.id);
                    confirm += "<li><span class=\"layui-badge-dot layui-bg-black\"></span>&nbsp;" + item.试剂名称 + "</li>";
                    total += item.总金额;
                });
                confirm += "</ul>";
                layer.confirm(confirm, function (index) {
                    $.post('resolveCommonDeviceBatch', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("commonDeviceHistoryTable")
                            table.reload("commonDeviceTable")
                     }
                    });
                });
            }
        });
    </script>
@endsection