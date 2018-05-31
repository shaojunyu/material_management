@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <h2 style="display: inline">普通试剂管理</h2>
                {{--<button class="layui-btn" style="margin-left: 20px" onclick="addCommonChem()">添加</button>--}}
                {{--<button class="layui-btn" style="margin-left: 20px" onclick="downloadTable()">下载报表</button>--}}
            </blockquote>

            {{--待审核--}}
            <div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>待审核</legend>
                </fieldset>
                <table id="submittedCommonChemOrdersTable" lay-filter="submittedCommonChemOrdersTable">
                </table>
            </div>
            <div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>已审核完成</legend>
                </fieldset>
                {{--审核通过--}}
                <table id="approvedCommonChemOrdersTable" lay-filter="approvedCommonChemOrdersTable">

                </table>
            </div>
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
            elem: '#submittedCommonChemOrdersTable'
            , url: 'submittedCommonChemOrders'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'}
                , {field: 'id', title: '批次编号', width: 100}
                , {field: 'intro', title: '内容'}
                , {field: '总金额', title: '总金额(￥)'}
                , {field: 'created_at', title: '创建时间'}
                , {
                    field: 'status', title: '状态', templet: function (d) {
                        if (d.status === 'submitted')
                            return "已提交，等待审核";
                        if (d.status === "done")
                            return "已完成审核";
                    }
                }
                , {
                    fixed: 'right', align: 'center', templet: function (d) {
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
                    }
                }
            ]]
        });

        table.render({
            elem: '#approvedCommonChemOrdersTable'
            , url: 'approvedCommonChemOrders'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'}
                , {field: 'id', title: '批次编号', width: 100}
                , {field: 'intro', title: '内容'}
                , {field: '总金额', title: '总金额(￥)'}
                , {field: 'created_at', title: '创建时间'}
                , {
                    field: 'status', title: '状态', templet: function (d) {
                        if (d.status === 'submitted')
                            return "已提交，等待审核";
                        if (d.status === "done")
                            return "已完成审核";
                    }
                }
                , {
                    fixed: 'right', align: 'center', templet: function (d) {
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
                    }
                }
            ]]
        });
    </script>
    {{--详情模板--}}
    <div id="batchCommonChemDetail" hidden style="padding: 10px;">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>批次编号：@{{ id }} &nbsp;| &nbsp;总金额：@{{ total }}</legend>
        </fieldset>
        <table class="layui-table">
            <thead>
            <tr>
                <th>试剂名称</th>
                <th>规格</th>
                <th>数量</th>
                <th>单价</th>
                <th>小计</th>
                <th>申报日期</th>
                <th>负责人</th>
                <th>负责人号码</th>
                <th>申购单位</th>
                <th>供应商</th>
                <th>供应商电话</th>
                <th>经费编号</th>
                <th>经费名称</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="chemical in chemicals">
                <td>@{{ chemical.试剂名称 }}</td>
                <td>@{{ chemical.规格 }}</td>
                <td>@{{ chemical.数量 }}</td>
                <td>@{{ chemical.单价 }}</td>
                <td>@{{ chemical.小计 }}</td>
                <td>@{{ chemical.申报日期 }}</td>
                <td>@{{ chemical.申购人姓名 }}</td>
                <td>@{{ chemical.申购人号码 }}</td>
                <td>@{{ chemical.申购单位 }}</td>
                <td>@{{ chemical.供应商 }}</td>
                <td>@{{ chemical.供应商电话 }}</td>
                <td>@{{ chemical.经费编号 }}</td>
                <td>@{{ chemical.经费名称 }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <script>
        var app = new Vue({
            el: '#batchCommonChemDetail',
            data: {
                chemicals: [],
                id: '',
                total: 0
            }
        });
        //监听表格工具条
        table.on('tool(submittedCommonChemOrdersTable)', function (obj) {
            var data = obj.data;
            if (obj.event === 'view') {
                app.chemicals = data.chemicals;
                app.id = data.id;
                app.total = data.总金额;
                layer.open({
                    type: 1,
                    content: $("#batchCommonChemDetail"),
                    title: '批次详情1',
                    area: ['1300px','700px']
                });
            } else if (obj.event === 'approve') {
                layer.confirm('确定“审核通过”该批次数据么？批次号：' + obj.data.id, function (index) {
                    $.post('approveChemBatch', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("approvedCommonChemOrdersTable");
                            table.reload("submittedCommonChemOrdersTable");
                        }
                    });
                });
            } else if (obj.event === 'del') {
                layer.confirm('确定删除该批次数据么？批次号：' + obj.data.id, function (index) {
                    $.post('batchDeleteCommonChem', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("approvedCommonChemOrdersTable");
                            table.reload("submittedCommonChemOrdersTable");
                        }
                    });
                });
            } else if (obj.event === 'download') {
                var ids = [];
                var total = 0;
                var confirm = "<h3>您将下载该批次的申报文件，请确认!<br>";
                confirm += "<h3>批次号：" + data.id + "<br><ul>";
                data.chemicals.forEach(function (item) {
                    ids.push(item.id);
                    confirm += "<li><span class=\"layui-badge-dot layui-bg-black\"></span>&nbsp;" + item.试剂名称 + "</li>";
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
                var url = 'batchDownloadCommonChemForm?id=' + data.id;
                layer.confirm(confirm, function (index) {
                    window.open(url);
                    table.reload("approvedCommonChemOrdersTable");
                    table.reload("submittedCommonChemOrdersTable");
                    layer.close(index);
                });
            }
        });

        table.on('tool(approvedCommonChemOrdersTable)', function (obj) {
            var data = obj.data;
            if (obj.event === 'view') {
                app.chemicals = data.chemicals;
                app.id = data.id;
                app.total = data.总金额;
                layer.open({
                    type: 1,
                    content: $("#batchCommonChemDetail"),
                    title: '批次详情',
                    area: ['1300px','700px']
                });
            } else if (obj.event === 'approve') {
                layer.confirm('确定“审核通过”该批次数据么？批次号：' + obj.data.id, function (index) {
                    $.post('approveChemBatch', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("approvedCommonChemOrdersTable");
                            table.reload("submittedCommonChemOrdersTable");
                        }
                    });
                });
            } else if (obj.event === 'del') {
                layer.confirm('确定删除该批次数据么？批次号：' + obj.data.id, function (index) {
                    $.post('batchDeleteCommonChem', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("approvedCommonChemOrdersTable");
                            table.reload("submittedCommonChemOrdersTable");
                        }
                    });
                });
            } else if (obj.event === 'download') {
                var ids = [];
                var total = 0;
                var confirm = "<h3>您将下载该批次的申报文件，请确认!<br>";
                confirm += "<h3>批次号：" + data.id + "<br><ul>";
                data.chemicals.forEach(function (item) {
                    ids.push(item.id);
                    confirm += "<li><span class=\"layui-badge-dot layui-bg-black\"></span>&nbsp;" + item.试剂名称 + "</li>";
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
                var url = 'batchDownloadCommonChemForm?id=' + data.id;
                layer.confirm(confirm, function (index) {
                    window.open(url);
                    table.reload("approvedCommonChemOrdersTable");
                    table.reload("submittedCommonChemOrdersTable");
                    layer.close(index);
                });
            }
        });
    </script>
@endsection