<div style="padding: 15px;" id="addRadioactive">
    <form class="layui-form" action="" lay-filter="editRadioactiveForm" id="editRadioactiveForm">
        {{ csrf_field() }}
        <input hidden name="id" value="{{ $element['id'] }}">
        <div class="layui-form-mid layui-word-aux">带*为必填项</div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">实验室名称*</label>
                <div class="layui-input-inline">
                    <input type="text" name="实验室名称" id="nameInput" required lay-verify="required"
                           class="layui-input" value="{{ $element['实验室名称'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">实验室负责人*</label>
                <div class="layui-input-inline">
                    <input type="text" name="实验室负责人" required lay-verify="required" class="layui-input"
                           value="{{ $element['实验室负责人'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">负责人手机*</label>
                <div class="layui-input-inline">
                    <input type="text" name="负责人手机" required lay-verify="required|phone" class="layui-input"
                           value="{{ $element['负责人手机'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">负责人邮箱*</label>
                <div class="layui-input-inline">
                    <input type="text" name="负责人邮箱" required lay-verify="required|email" class="layui-input"
                           value="{{ $element['负责人邮箱'] }}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">保存地点及条件*</label>
                <div class="layui-input-inline">
                    <input type="text" name="保存地点及条件" required lay-verify="required" class="layui-input"
                           value="{{ $element['保存地点及条件'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">使用场所*</label>
                <div class="layui-input-inline">
                    <input type="text" name="使用场所" required lay-verify="required" class="layui-input"
                           value="{{ $element['使用场所'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">辐射工作人员持证上岗情况*</label>
                <div class="layui-input-inline">
                    <input type="text" name="辐射工作人员持证上岗情况" required lay-verify="required" class="layui-input"
                           value="{{ $element['辐射工作人员持证上岗情况'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">安全防护措施*</label>
                <div class="layui-input-inline">
                    <input type="text" name="安全防护措施" required lay-verify="required" class="layui-input"
                           value="{{ $element['安全防护措施'] }}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申购理由</label>
            <div class="layui-input-block">
                <input type="text" name="申购理由" lay-verify="title" lay-verify="required" autocomplete="off"
                       placeholder="申购理由" class="layui-input" style="width: 90%"
                       value="{{ $element['申购理由'] }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">放射废物处置方案
            </label>
            <div class="layui-input-block">
                <input type="text" name="放射废物处置方案" lay-verify="title" lay-verify="required" autocomplete="off"
                       placeholder="放射废物处置方案" class="layui-input" style="width: 90%"
                       value="{{ $element['放射废物处置方案'] }}">
            </div>
        </div>
        <div class="layui-elem-quote">
            <p>申购内容(注：非密封放射性物质的申请购买量以半年使用量为准，其出厂活度不能超过学校《辐射安全许可证》允许的该同位素年最大用量。)</p>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">放射性同位素名称*</label>
                <div class="layui-input-inline">
                    <input type="text" name="放射性同位素名称" required lay-verify="required" class="layui-input" value="{{ $element['放射性同位素名称'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">放射性同位素活度*</label>
                <div class="layui-input-inline">
                    <input type="text" name="放射性同位素活度" required lay-verify="required" class="layui-input"
                           value="{{ $element['放射性同位素活度'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">射线装置名称*</label>
                <div class="layui-input-inline">
                    <input type="text" name="射线装置名称" required lay-verify="required" class="layui-input"
                           value="{{ $element['射线装置名称'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">台数*</label>
                <div class="layui-input-inline">
                    <input type="text" name="台数" required lay-verify="required" class="layui-input"
                           value="{{ $element['台数'] }}">
                </div>
            </div>
        </div>
        <div class="layui-elem-quote">
            <p>生产单位</p>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">厂家名称*</label>
                <div class="layui-input-inline">
                    <input type="text" name="厂家名称" required lay-verify="required" class="layui-input"
                           value="{{ $element['厂家名称'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">辐射许可证编号*</label>
                <div class="layui-input-inline">
                    <input type="text" name="辐射许可证编号" required lay-verify="required" class="layui-input"
                           value="{{ $element['辐射许可证编号'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">通讯地址*</label>
                <div class="layui-input-inline">
                    <input type="text" name="通讯地址" required lay-verify="required" class="layui-input"
                           value="{{ $element['通讯地址'] }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">联系人/电话*</label>
                <div class="layui-input-inline">
                    <input type="text" name="联系人" required lay-verify="required" class="layui-input"
                           value="{{ $element['联系人'] }}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="editRadioactiveForm">立即提交</button>
                <button class="layui-btn layui-btn-normal" onclick="updateDraft()">保存信息</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script>
    form.render();
    form.on('submit(editRadioactiveForm)',function (data) {
        layer.confirm('确认提交申购？请确认信息准确！管理员会审核信息！', function(index){
            $.post('submitRadioactive',data.field,function (d) {
                if(d.code == 0){
                    layer.closeAll();
                    table.reload("radioactiveTable");
                }
                layer.msg(d.message);
            });
            layer.close(index);
        });
        return false;
    });

    function updateDraft() {
        var allInputs = $("#editRadioactiveForm").serializeArray();
        var numOfNone = 0;
        $.each(allInputs,function (index,item) {
            if (item.value === "")
                numOfNone++;
        });
        if (numOfNone === 18){
            layer.alert("请至少填入一项信息！");
            Event.preventDefault();
            return false;
        }
        $.ajax({
            type: "POST",
            url: "updateRadioactive",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $("#editRadioactiveForm").serialize(),
            success: function (d) {
                table.reload("radioactiveTable");
                layer.closeAll();
                layer.msg(d.message, {icon: 1,time:2*1000});
            }
        });
        event.preventDefault();
        return false;
    }
</script>