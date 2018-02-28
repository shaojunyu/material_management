@extends('layouts.admin')
@section('main-body')
    <style>
        .layui-form-label{
            width: 120px;
        }
    </style>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <img src="images/radioactive2.png">
                <h2 style="display: inline">放射性同位素与射线装置申购</h2>
                <button class="layui-btn" style="margin-left: 20px" onclick="addRadioactive()">添加新的申购</button>
                {{--<button class="layui-btn" style="margin-left: 20px" onclick="downloadTable()">下载报表</button>--}}
            </blockquote>
            <table id="radioactiveTable" lay-filter="radioactiveTable">
            </table>
        </div>
    </div>
    <div style="display: none; padding: 15px;" id="addRadioactive">
        <form class="layui-form" action="" lay-filter="addRadioactiveForm" id="addRadioactiveForm">
            {{ csrf_field() }}
            <div class="layui-form-mid layui-word-aux">带*为必填项</div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">实验室名称*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="实验室名称" id="nameInput" required lay-verify="required"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">实验室负责人*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="实验室负责人" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">负责人手机*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="负责人手机" required lay-verify="required|phone" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">负责人邮箱*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="负责人邮箱" required lay-verify="required|email" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">保存地点及条件*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="保存地点及条件" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">使用场所*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="使用场所" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">辐射工作人员持证上岗情况*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="辐射工作人员持证上岗情况" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">安全防护措施*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="安全防护措施" required lay-verify="required" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">申购理由</label>
                <div class="layui-input-block">
                    <input type="text" name="申购理由" lay-verify="required" autocomplete="off" placeholder="申购理由" class="layui-input" style="width: 90%" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">放射废物处置方案
                </label>
                <div class="layui-input-block">
                    <input type="text" name="放射废物处置方案" lay-verify="required" autocomplete="off" placeholder="放射废物处置方案" class="layui-input" style="width: 90%" >
                </div>
            </div>
            <div class="layui-elem-quote">
                <p>申购内容(注：非密封放射性物质的申请购买量以半年使用量为准，其出厂活度不能超过学校《辐射安全许可证》允许的该同位素年最大用量。)</p>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">放射性同位素名称*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="放射性同位素名称" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">放射性同位素活度*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="放射性同位素活度" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">射线装置名称*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="射线装置名称" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">台数*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="台数" required lay-verify="required" class="layui-input">
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
                        <input type="text" name="厂家名称" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">辐射许可证编号*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="辐射许可证编号" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">通讯地址*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="通讯地址" required lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">联系人/电话*</label>
                    <div class="layui-input-inline">
                        <input type="text" name="联系人" required lay-verify="required" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="addRadioactiveForm">立即提交</button>
                    <button class="layui-btn layui-btn-normal" onclick="storeDraft()">保存信息</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        var form = layui.form;
        var table = layui.table;
        table.render({
            elem: '#radioactiveTable'
            , url: 'radioactiveList'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'}
                ,{field: 'id', title: '编号'}
                , {field: '放射性同位素名称', title: '放射性同位素'}
                , {field: '射线装置名称', title: '射线装置名称'}
                , {field: '实验室负责人', title: '实验室负责人'}
                , {field: '负责人手机', title: '负责人手机'}
                , {field: '保存地点及条件', title: '保存地点及条件'}
                ,{field: 'approved_at',title: '状态', templet:function (d) {
                    if(d.approved_at){
                        return "已审批："+d.approved_at;
                    }else if (d.status === "applying"){
                        return "草稿，尚未提交审批"
                    }else if(d.status === "submitted"){
                        return "已提交，等待审批"
                    }
                }}
                , {fixed: 'right', width:200, align:'center', templet:function (d) {
                    if (d.status === "applying")
                        return '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "submitted")
                        return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="download">下载报表</a>\n' +
                            '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n' +
                            '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    if (d.status === "done")
                        return '<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="download">下载报表</a>\n' +
                            '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>\n';
                }}
            ]]
        });
        function addRadioactive() {
            layer.open({
               type:1,
                title:'添加新的放射性物质申购',
                area:['1000px'],
               content:$("#addRadioactive")
            });
        }

        function storeDraft() {
            var allInputs = $("#addRadioactiveForm").serializeArray();
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
                url: "addRadioactive",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $("#addRadioactiveForm").serialize(),
                success: function (d) {
                    table.reload("radioactiveTable");
                    layer.closeAll();
                    layer.msg(d.message, {icon: 1,time:2*1000});
                }
            });

            event.preventDefault();
            return false;
        }
        form.on('submit(addRadioactiveForm)',function (data) {
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


        //监听表格工具条
        table.on('tool(radioactiveTable)', function(obj){
            var data = obj.data;
            if(obj.event === 'view'){
                $.post('radioactiveDetail',{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                } ,function(str){
                    layer.open({
                        type: 1,
                        area:['1000px'],
                        content: str ,
                        title: '详情',
                    });
                });

            } else if(obj.event === "edit"){
                $.post("editRadioactive",{
                    id:obj.data.id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                },function (str) {
                    layer.open({
                        type:1,
                        title:'编辑放射性物质申购',
                        area:['1000px'],
                        content:str
                    });
                });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除申购数据么，编号：' + obj.data.id, function(index){
                    $.post('deleteRadioactive',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code == 0){
                            table.reload("radioactiveTable")
                        }
                    });
                });
            } else if(obj.event === 'download'){
                var url = 'downloadRadioactiveForm?id='+obj.data.id;
                window.open(url);
            }
        });
    </script>
@endsection