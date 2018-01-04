<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>生科院耗材管理系统</title>
    <link rel="stylesheet" href="../css/layui.css">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <a href="home"><div class="layui-logo">生科院耗材管理系统</div></a>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="./home">信息录入</a></li>
            <li class="layui-nav-item"><a href="">历史记录</a></li>
            {{--
            <li class="layui-nav-item"><a href="">用户</a></li>
            --}}
            {{--
            <li class="layui-nav-item">--}}
                {{--<a href="javascript:;">其它系统</a>--}}
                {{--
                <dl class="layui-nav-child">--}}
                    {{--
                    <dd><a href="">邮件管理</a></dd>
                    --}}
                    {{--
                    <dd><a href="">消息管理</a></dd>
                    --}}
                    {{--
                    <dd><a href="">授权管理</a></dd>
                    --}}
                    {{--
                </dl>
                --}}
                {{--
            </li>
            --}}
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    {{--<img src="http://t.cn/RCzsdCq" class="layui-nav-img">--}}
                    {{ Auth::user()->name }}
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" onclick="userInfo()">基本资料</a></dd>
                    <dd><a href="javascript:;" onclick="changePasswd()">密码重置</a></dd>
                    <dd>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            退出登陆
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </dd>
                </dl>
            </li>
            {{--
            <li class="layui-nav-item">--}}

                {{--
            </li>
            --}}
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">药品申购与入库</a>
                    <dl class="layui-nav-child">
                        <dd><a href="HazardousChemical">危险化学品申购</a></dd>
                        <dd><a href="HazardousChemicalOrder">危化品申购记录</a></dd>
                        <dd><a href="CommonChemical">普通试剂入库</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">耗材管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="commonDevice">低值设备入库</a></dd>
                        <dd><a href="javascript:;">贵重设备申报</a></dd>
                        <dd><a href="">超链接</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">系统管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="./hazardousChemicalManage">危化品管理</a></dd>
                        <dd><a href="">危化品申报管理</a></dd>
                        <dd><a href="">普通试剂管理管理</a></dd>
                        <dd><a href="">低值设备管理</a></dd>
                        <dd><a href="">贵重设备申报管理</a></dd>
                        <dd><a href="./userManage">用户管理</a></dd>
                    </dl>
                </li>

            </ul>
        </div>
    </div>
    @section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            生科院耗材管理系统
        </div>
    </div>
    @show
    <div class="layui-footer" onmouseover="showMe()">
        <!-- 底部固定区域 -->
        © HUST-Life
    </div>
</div>
<script src="../js/layui.all.js"></script>
</body>
<div id="userInfo" style="display: none">
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <td>登录名</td>
            <td>{{ Auth::user()->staff_id }}</td>
        </tr>
        <tr>
            <td>姓名</td>
            <td>{{ Auth::user()->name }}</td>
        </tr>
        <tr>
            <td>是否为管理员</td>
            <td>
                @if(Auth::user()->is_admin === 0)
                    否
                @else
                    是
                @endif
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div style="display: none" id="changePassword">
    <form method="post" class="layui-form" onsubmit="return checkChangePasswordForm()" action="./changePassword" style="margin-right: 20px; margin-top: 20px">
        {{ csrf_field() }}
        <div class="layui-form-item">
            <label class="layui-form-label">旧密码</label>
            <div class="layui-input-block">
                <input type="text" name="oldPassword" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">新密码</label>
            <div class="layui-input-block">
                <input type="text" name="newPassword" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">再次输入新密码</label>
            <div class="layui-input-block">
                <input type="text" name="newPassword2" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置表单</button>
            </div>
        </div>
    </form>
</div>
{{--{{$changePassword}}--}}
@if(!empty($changePassword))
    @if($changePassword == 1)
        <script>
            layer.open({
                type: 0,
                content: '密码修改成功！', //这里content是一个普通的String
                end: function () {
                    window.location.href = "/home";
                }
            });
        </script>
    @else
        <script>
            layer.open({
                type: 0,
                content: '密码修改失败，请重试！', //这里content是一个普通的String
                end: function () {
                    window.location.href = "/home";
                }
            });
        </script>
    @endif
@endif
<script>
    var $ = layui.$;
    function userInfo() {
        var $ = layui.$;
        layer.open({
            type: 1,
            title: "用户信息",
            content: $('#userInfo') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
        });
    }

    function changePasswd() {
        var $ = layui.$;
        layer.open({
            type: 1,
            title: "修改密码",
            content: $('#changePassword')
        });
    }
    function checkChangePasswordForm() {
        var $ = layui.$;
        if ($("[name='newPassword']").val() != $("[name='newPassword2']").val()){
            alert("新密码不一致");
            return false;
        }
    }

    setInterval(function () {
        $.ajax({
            url:'authorised',
            statusCode:{
                401:function () {
                    window.location.reload()
                }
            }
        })
    },60000)

    function showMe() {
        layer.msg("Bug report: yushaojun@hust.edu.cn");
    }
</script>
@section('script')

@show
</html>