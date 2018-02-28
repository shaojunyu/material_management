<form class="layui-form" action="updateUser" lay-filter="updateUserForm">
    {{ csrf_field() }}
    <div class="layui-form-mid layui-word-aux">带*为必填项</div>
    <input hidden name="id" value="{{ $user->id }}">
    <div class="layui-form-item">
        <label class="layui-form-label">人事编号*</label>
        <div class="layui-input-block">
            <input type="text" name="staff_id" required lay-verify="required"
                   autocomplete="off" class="layui-input" value="{{ $user->staff_id }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">姓名*</label>
        <div class="layui-input-inline">
            <input type="text" name="name" required lay-verify="required|name" autocomplete="off"
                   class="layui-input" value="{{ $user->name }}">
        </div>
    </div>
    <div class="layui-form-mid layui-word-aux">密码留空，则不修改</div>
    <div class="layui-form-item">

        <label class="layui-form-label">密码*</label>
        <div class="layui-input-inline">
            <input type="text" name="password" required autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="updateUserForm">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script>
    //监听提交
    form.on('submit(updateUserForm)', function (data) {
        console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
        console.log(data.form.action) //被执行提交的form对象，一般在存在form标签时才会返回
        console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
//        return false;
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