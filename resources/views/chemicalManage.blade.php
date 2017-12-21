@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                危险化学药品管理
                <button class="layui-btn" style="margin-left: 20px" onclick="openAddForm()">添加危险化学品</button>

            </blockquote>
            <table id="hazardousChemicals" lay-filter="hazardousChemicals">

            </table>
        </div>
    </div>


    {{--添加数据的表单--}}
    <div id="addHahadChem" style="display: none; margin: 10px 20px 20px 30px;">
        <form class="layui-form" action="addHazardChem" lay-filter="addHahadChem">
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
                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
    <div  id="editDiv" style="display: none; margin: 10px 20px 20px 30px;">

    </div>
@endsection
@section('script')
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
        //    var $ = layui.$
        var form = layui.form
        var table = layui.table;
        table.render({
            elem: '#hazardousChemicals'
            , url: 'hazardousChemicalList'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type:'checkbox'},
//                {field: 'id', title: 'ID', width: 60, sort: true, fixed: 'left'}
                {field: 'CAS', title: 'CAS'}
                , {field: '中文名', title: '中文名'}
                , {field: '别名', title: '别名'}
                , {field: '备注', title: '备注'}
                , {field: 'hazardousTypeName', title: '种类'},
                {fixed: 'right', width:150, align:'center', toolbar: '#barDemo'}
            ]]
        });
        //监听表格工具条
        table.on('tool(hazardousChemicals)', function(obj){
            var data = obj.data;
            if(obj.event === 'detail'){
                layer.msg('ID：'+ data.id + ' 的查看操作');
            } else if(obj.event === 'del'){
                layer.confirm('确定删除数据么：' + obj.data.中文名, function(index){

                    $.post('deleteHazardChem',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.open({
                            type: 0,
                            content: d.message, //这里content是一个普通的String
                        });
                        if(d.code == 0){
                            layer.close(index);
                            obj.del();
                        }
                    });
                });
            } else if(obj.event === 'edit'){
                $.post('editHazardChem',{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                } ,function(str){
                    $("#editDiv").html(str);
                    layer.open({
                        type: 1,
                        content: $("#editDiv") ,
                        title: '更新化学品信息'
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

        form.on('submit', function (data) {
            console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
            console.log(data.form.action) //被执行提交的form对象，一般在存在form标签时才会返回
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
//            return false;
            $.post(data.form.action, data.field, function (d) {
                layer.open({
                    type: 0,
                    content: d.message, //这里content是一个普通的String
                    end: function () {
                        location.reload()
                    }
                });
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

    </script>
@endsection
