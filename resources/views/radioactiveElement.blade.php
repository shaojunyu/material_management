@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <img src="images/radioactive2.png">
                <h2 style="display: inline">放射性同位素与射线装置申购</h2>
                <button class="layui-btn" style="margin-left: 20px" onclick="addRadioactive()">添加</button>
                <button class="layui-btn" style="margin-left: 20px" onclick="downloadTable()">下载报表</button>
            </blockquote>
            <table id="radioactiveTable" lay-filter="radioactiveTable">
            </table>
        </div>
    </div>
    <div style="display: none; padding: 15px;" id="addRadioactive">
        <form class="layui-form" action="" lay-filter="addRadioactiveForm">
            {{ csrf_field() }}
            <div class="layui-form-mid layui-word-aux">带*为必填项</div>
            <div class="layui-inline">
                <label class="layui-form-label">实验室名称*</label>
                <div class="layui-input-block">
                    <input type="text" name="实验室名称" id="nameInput" required lay-verify="required"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">实验室负责人*</label>
                <div class="layui-input-block">
                    <input type="text" name="实验室负责人" required lay-verify="required" class="layui-input">
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
        function addRadioactive() {
            layer.open({
               type:1,
                title:'添加新的申购',
                area:['1000px'],
               content:$("#addRadioactive")
            });
        }
    </script>
@endsection