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
                <img src="images/chemical2.png">
                <h2 style="display: inline">普通试剂入库</h2>
                <button class="layui-btn" style="margin-left: 15px" onclick="showHistory()">显示历史记录</button>
                <button class="layui-btn" style="margin-left: 15px" onclick="addCommonChem()">添加</button>
                <button class="layui-btn" style="margin-left: 15px" onclick="downloadTable()">提交审核</button>
                <button class="layui-btn" style="margin-left: 15px" id="emptyButton" onclick="emptyTable()">清空列表</button>
                    <button class="layui-btn" style="margin-left: 15px" id="uploadButton">一键导入
                </button>
                <a style="margin-left: 20px" href="docs/普通试剂导入模板.xlsx">下载模板</a>
            </blockquote>
            <table id="commonChemTable" lay-filter="commonChemTable">
            </table>
            <div>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>历史记录</legend>
                </fieldset>
                <table id="commonChemHistoryTable" lay-filter="commonChemHistoryTable">
                </table>
            </div>
        </div>
    </div>
    <div style="display: none; padding: 15px;" id="addCommonChem">
        <form class="layui-form" action="" lay-filter="addCommonChemForm">
            {{ csrf_field() }}
            <div class="layui-form-mid layui-word-aux">带*为必填项</div>
            <div class="layui-form-item">
                <label class="layui-form-label">试剂名称*</label>
                <div class="layui-input-block">
                    <input type="text" name="试剂名称" id="nameInput" required onchange="checkIfHazard()"
                           lay-verify="required"
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
                    <input id="count" onchange="caculateTotal()" type="text" name="数量" required
                           lay-verify="required|number"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">单价（元）*</label>
                <div class="layui-input-block">
                    <input id="price" onchange="caculateTotal()" type="text" name="单价" required
                           lay-verify="required|number"
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
    {{--<a hidden href="google.com" download="d.doc" id="donwloadLink">a</a>--}}
@endsection
@section('script')
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="view">查看</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
        var form = layui.form;
        var table = layui.table;
        var laytpl = layui.laytpl;
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
            var total = 0;
            var confirm = "<h3>以下物品会打包成一个批次，请确认!<br><ul>";
            checkStatus.data.forEach(function (item) {
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
            var url = 'downloadCommonChemForm?ids=' + encodeURI(JSON.stringify(ids));
            layer.confirm(confirm, function (index) {
                table.reload("commonChemTable");
                table.reload("commonChemHistoryTable");
                layer.close(index);
                window.open(url);
                setTimeout(function () {
                    table.reload("commonChemTable");
                    table.reload("commonChemHistoryTable");
                }, 2000);
            });
        }

        function checkIfHazard() {
            var text = $("#nameInput").val()
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
                    return false;
                }
                else {
                    return true;
                }
            });

        }

        function showHistory() {
            layer.load();
            table.render({
                elem: '#commonChemHistoryTable'
                , url: 'commonChemHistoryList'
                , limit: 20
                , page: true //开启分页
                , cols: [[ //表头
                    // {type: 'checkbox'}
                     {field: 'id', title: '批次编号', width: 100}
                    , {field: 'intro', title: '内容'}
                    , {field: '总金额', title: '总金额(￥)', width:100}
                    , {field: 'created_at', title: '创建时间'}
                    , {
                        field: 'status', title: '状态', width:150, templet: function (d) {
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
                type: 'commonChem'
            },
            exts: 'xlsx|csv',
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
                    //window.location.reload();
                });
            }
        });

        function emptyTable() {
            layer.confirm('确定清空以下列表中的数据么？<br>(历史记录不收影响)', function (index) {
                $.get('emptyCommonChemList', function (d) {
                    // layer.msg(d.message);
                    if (d.code == 0) {
                        layer.close(index)
                        table.reload("commonChemTable")
                    }
                });
            });
        }

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
                <th>单价（￥）</th>
                <th>小计（￥）</th>
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
                <td>@{{ chemical.总金额 }}</td>
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
        table.on('tool(commonChemHistoryTable)', function (obj) {
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
            } else if (obj.event === 'del') {
                layer.confirm('确定删除该批次数据么？批次号：' + obj.data.id, function (index) {
                    $.post('batchDeleteCommonChem', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("commonChemHistoryTable")
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
                    table.reload("commonChemTable");
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
                var url = 'batchDownloadCommonChemForm?id=' + data.id;
                layer.confirm(confirm, function (index) {
                    $.post('resolveCommonChemBatch', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message);
                        if (d.code == 0) {
                            table.reload("commonChemHistoryTable")
                            table.reload("commonChemTable")
                        }
                    });
                });
            }
        });
    </script>
@endsection