@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <h2 style="display: inline;">危险化学药品管理</h2>
                <button class="layui-btn" style="margin-left: 20px" onclick="openAddForm()">添加危险化学品</button>
                <div class="layui-form-item" style="display:inline-block; max-width: 300px;margin-top: 10px">
                    <label class="layui-form-label">输入搜索</label>
                    <div class="layui-input-block">
                        <input type="text" name="CAS" required lay-verify="required" placeholder="请输入..."
                               autocomplete="off" class="layui-input" oninput="search(this)" value="{{ $search }}">
                    </div>
                </div>
            </blockquote>
            <table id="hazardousChemicals" lay-filter="hazardousChemicals">
            </table>
        </div>
    </div>

    {{--添加数据的表单--}}
    <div id="addHahadChem" style="display: none; margin: 10px 20px 20px 30px;">
        <form class="layui-form" action="addHazardChem" lay-filter="addHazardChem">
            {{ csrf_field() }}
            <div class="layui-form-mid layui-word-aux">带*为必填项</div>
            <div class="layui-form-item">
                <label class="layui-form-label">CAS号*</label>
                <div class="layui-input-block">
                    <input type="text" name="CAS" required lay-verify="required" placeholder="请输入CAS号"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">中文名*</label>
                <div class="layui-input-inline">
                    <input type="text" name="中文名" required lay-verify="required" placeholder="请输入中文名" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">危化品种类*</label>
                <div class="layui-input-block">
                    <select name="hazardous_type" lay-verify="required">
                        <option value=""></option>
                        <option value="1">剧毒化学品</option>
                        <option value="2">易制毒化学品</option>
                        <option value="3">易制爆化学品</option>
                        <option value="4">精神麻醉类化学品</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">别名</label>
                <div class="layui-input-inline">
                    <input type="text" name="别名" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-inline">
                    <input type="text" name="备注" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="addHazardChem">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>

    <div id="addInForm" style="display: none; margin: 10px 20px 20px 30px;">
        <form class="layui-form" action="addInForm" lay-filter="addInForm">
            {{ csrf_field() }}
            <div class="layui-form-mid layui-word-aux">带*为必填项</div>
            <div class="layui-form-item">
                <label class="layui-form-label">数量*</label>
                <div class="layui-input-block">
                    <input type="text" name="数量" lay-verify="required" placeholder="请输入数量号"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">存放地*</label>
                <div class="layui-input-inline">
                    <input type="text" name="存放地" lay-verify="required" placeholder="请输入存放地"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">负责人*</label>
                <div class="layui-input-inline">
                    <input type="text" name="负责人" lay-verify="required" placeholder="请输入负责人" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系电话*</label>
                <div class="layui-input-inline">
                    <input type="text" name="联系电话" lay-verify="required|phone" placeholder="请输入负责人联系电话" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-inline">
                    <input type="text" name="备注" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="addInForm">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
    <div id="addOutForm" style="display: none; margin: 10px 20px 20px 30px;">
        <form class="layui-form" action="addOutForm" lay-filter="addOutForm">
            {{ csrf_field() }}
            <div class="layui-form-mid layui-word-aux">带*为必填项</div>
            <div class="layui-form-item">
                <label class="layui-form-label">数量*</label>
                <div class="layui-input-block">
                    <input type="text" name="数量" lay-verify="required" placeholder="请输入数量号"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">存放地*</label>
                <div class="layui-input-inline">
                    <input type="text" name="存放地" lay-verify="required" placeholder="请输入存放地"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">负责人*</label>
                <div class="layui-input-inline">
                    <input type="text" name="负责人" lay-verify="required" placeholder="请输入负责人" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系电话*</label>
                <div class="layui-input-inline">
                    <input type="text" name="联系电话" lay-verify="required|phone" placeholder="请输入负责人联系电话" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-inline">
                    <input type="text" name="备注" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="addOutForm">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>

    <div id="editDiv" style="display: none; margin: 10px 20px 20px 30px;">
    </div>

    <div id="inOutDiv" style="display: none; margin: 10px 20px 20px 30px;">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>@{{ chem_name }}
                <button class="layui-btn" style="margin-left: 20px" onclick="openAddInForm()">添加入库记录</button>
                <button class="layui-btn" style="margin-left: 20px" onclick="openAddOutForm()">添加出库记录</button>
            </legend>
        </fieldset>
        入库
        <table id="inTable" lay-filter="inTable"></table>
        出库
        <table id="outTable" lay-filter="outTable"></table>
    </div>
@endsection
@section('script')
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs  layui-btn-primary" lay-event="inOut">进出库</a>
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/html" id="inTableTool">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/html" id="outTableTool">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
        var form = layui.form;
        var table = layui.table;
        var current_chem_id = ''; //记录当前打开进出库化学品的id
        var app = new Vue({
            el: '#inOutDiv',
            data: {
                chem_name:""
            }
        });
        table.render({
            elem: '#inTable'
            , url: 'hazardousChemicalInTable'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {field: 'id', title: 'ID', width:20}
            ,{field: '数量', title: '数量', width:100}
            , {field: '存放地', title: '存放地',width:100}
            , {field: '负责人', title: '负责人',width:100}
            , {field: '联系电话', title: '联系电话',width:150}
            , {field: 'created_at', title: '时间',width:150}
            , {field: '备注', title: '备注'},
            {fixed: 'right', width: 200, align: 'center', toolbar: '#inTableTool'}
        ]]
        });
        table.render({
            elem: '#outTable'
            , url: 'hazardousChemicalOutTable'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {field: 'id', title: 'ID', width:20}
                ,{field: '数量', title: '数量', width:100}
                , {field: '存放地', title: '存放地',width:100}
                , {field: '负责人', title: '负责人',width:100}
                , {field: '联系电话', title: '联系电话',width:150}
                , {field: 'created_at', title: '时间',width:150}
                , {field: '备注', title: '备注'},
                {fixed: 'right', width: 200, align: 'center', toolbar: '#outTableTool'}
            ]]
        });
        table.render({
            elem: '#hazardousChemicals'
            , url: 'hazardousChemicalList'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {field: 'CAS', title: 'CAS'}
                , {field: '中文名', title: '中文名'}
                , {field: '别名', title: '别名'}
                , {field: '备注', title: '备注'}
                , {field: 'hazardousTypeName', title: '种类'},
                {fixed: 'right', width: 200, align: 'center', toolbar: '#barDemo'}
            ]]
        });
        //监听表格工具条
        table.on('tool(hazardousChemicals)', function (obj) {
            var data = obj.data;
            if (obj.event === 'detail') {
                layer.msg('ID：' + data.id + ' 的查看操作');
            } else if (obj.event === 'del') {
                layer.confirm('确定删除数据么：' + obj.data.中文名, function (index) {

                    $.post('deleteHazardChem', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.open({
                            type: 0,
                            content: d.message, //这里content是一个普通的String
                        });
                        if (d.code == 0) {
                            layer.close(index);
                            obj.del();
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
                        title: '更新化学品信息'
                    });
                });
            } else if(obj.event === 'inOut') {
                current_chem_id = data.id;
                var chem_id = data.id;
                app.chem_name = data.中文名;
                var index = layer.load(2);
                table.reload('inTable', {
                    url: 'hazardousChemicalInTable?chem_id=' + chem_id,
                    request: {
                        pageName: 1
                    },
                    page: true,
                    done:function () {
                        layer.close(index);
                    }
                });
                table.reload('outTable', {
                    url: 'hazardousChemicalOutTable?chem_id=' + chem_id,
                    request: {
                        pageName: 1
                    },
                    page: true,
                    done:function () {
                        layer.close(index);
                    }
                });

                layer.open({
                    type: 1,
                    content: $("#inOutDiv"),
                    area: '1200px',
                    title: '更新化学品信息'
                });
            }
        });
        table.on('tool(inTable)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('确定删除该条入库记录么？<br/>ID:' + data.id, function (index) {
                    $.post('hazardousChemicalDeleteIn', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message, {
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        });
                        if (d.code == 0) {
                            layer.close(index);
                            table.reload('inTable');
                        }
                    });
                });
            }
        });

        table.on('tool(outTable)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('确定删除该条出库记录么？<br/>ID:' + data.id, function (index) {
                    $.post('hazardousChemicalDeleteOut', {
                        id: obj.data.id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (d) {
                        layer.msg(d.message, {
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        });
                        if (d.code == 0) {
                            layer.close(index);
                            table.reload('outTable')
                        }
                    });
                });
            }
        });

        function openAddForm() {
            layer.open({
                type: 1,
                content: $('#addHahadChem'),
                title: '添加化学品'
            });
        }

        form.on('submit(addHazardChem)', function (data) {
            console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
            console.log(data.form.action) //被执行提交的form对象，一般在存在form标签时才会返回
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            $.post(data.form.action, data.field, function (d) {
                layer.open({
                    type: 0,
                    content: d.message, //这里content是一个普通的String
                    end: function () {
                        table.reload('hazardousChemicals');
                    }
                });
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

        var addInFormLayer = '';
        function openAddInForm() {
            addInFormLayer = layer.open({
                type: 1,
                content: $('#addInForm'),
                title: '添加入库记录'
            });
        }
        form.on('submit(addInForm)', function (data) {
            data.field.chem_id = current_chem_id;
            $.post('hazardousChemicalAddIn', data.field, function (d) {
                table.reload('inTable');
                layer.msg(d.message, {
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function(){
                    layer.close(addInFormLayer);
                });
            });
            return false;
        });

        var addOutFormLayer = '';
        function openAddOutForm() {
            addOutFormLayer = layer.open({
                type: 1,
                content: $('#addOutForm'),
                title: '添加出库记录'
            });

        }
        form.on('submit(addOutForm)', function (data) {
            data.field.chem_id = current_chem_id;
            $.post('hazardousChemicalAddOut', data.field, function (d) {
                table.reload('outTable');
                layer.msg(d.message, {
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function(){
                    layer.close(addOutFormLayer);
                });
            });
            return false;
        });

        function search(obj) {
            var re = /'/;
            var text = $(obj).val();
            if (!re.test(text)) {
                console.log($(obj).val());
                layer.load(2);
                table.reload('hazardousChemicals', {
                    url: 'hazardousChemicalList?search=' + text,
                    request: {
                        pageName: 1
                    },
                    page: true,
                    done:function () {
                        layer.closeAll();
                    }
                });
            }
        }
    </script>
@endsection
