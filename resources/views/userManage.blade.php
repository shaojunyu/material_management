@extends('layouts.admin')
@section('main-body')
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <blockquote class="layui-elem-quote">
            用户管理
            <button class="layui-btn" style="margin-left: 20px" onclick="openAddForm()">添加新用户</button>
        </blockquote>
        <table id="userTable" lay-filter="userTable">
        </table>
    </div>
</div>
@endsection
@section('script')
<!--添加用户表单-->
<div id="addUserForm" style="display:none; margin: 10px 20px 20px 30px;">
    <form class="layui-form" action="addUser" lay-filter="addUserForm">
        {{ csrf_field() }}
        <div class="layui-form-mid layui-word-aux">带*为必填项</div>
        <div class="layui-form-item">
            <label class="layui-form-label">人事编号*</label>
            <div class="layui-input-block">
                <input type="text" name="staff_id" required lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">姓名*</label>
            <div class="layui-input-inline">
                <input type="text" name="name" required lay-verify="required|name" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码*</label>
            <div class="layui-input-inline">
                <input type="text" name="password" required lay-verify="required|pass" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="addUserForm">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script>
    var form = layui.form;
    var table = layui.table;
    table.render({
        elem: '#userTable'
        , url: 'userList'
        , limit: 20
        , page: true //开启分页
        , cols: [[ //表头
            {type:'checkbox'},
            {field: 'staff_id', title: '人事编号'}
            , {field: 'name', title: '姓名'}
            ,{fixed: 'right', width:150, align:'center', toolbar: '#barDemo'}
        ]]
    });

    //监听提交
    form.on('submit(addUserForm)', function (data) {
        console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
        console.log(data.form.action) //被执行提交的form对象，一般在存在form标签时才会返回
        console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
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

    //监听表格工具条
    table.on('tool(userTable)', function(obj){
        var data = obj.data;
        if(obj.event === 'edit'){
            $.post('editUser',{
                id:obj.data.id,
                _token:$('meta[name="csrf-token"]').attr('content')
            } ,function(str){
                layer.open({
                    type: 1,
                    content: str ,
                    title: '更新用户信息',
                    maxWidth:500
                });
            });

        } else if(obj.event === 'del'){
            layer.confirm('确定删除数据么：' + obj.data.name, function(index){
                $.post('deleteUser',{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                },function (d) {
                    layer.msg(d.message);
                    if(d.code == 0){
                        table.reload("userTable")
                    }
                });
            });
        }
    });

    form.verify({
        username: function(value, item){ //value：表单的值、item：表单的DOM对象
            if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                return '用户名不能有特殊字符';
            }
            if(/(^\_)|(\__)|(\_+$)/.test(value)){
                return '用户名首尾不能出现下划线\'_\'';
            }
            if(/^\d+\d+\d$/.test(value)){
                return '用户名不能全为数字';
            }
        }
        ,pass: [
            /^[\S]{6,12}$/
            ,'密码必须6到12位，且不能出现空格'
        ]
    });

    function openAddForm() {
        layer.open({
            type:1,
            content:$("#addUserForm"),
            title: '添加用户'
        })
    }

</script>
@endsection