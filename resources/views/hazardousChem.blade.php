@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                <img src="images/danger-16.png">
                <h2 style="display: inline">危险化学药品申购</h2>
                <button class="layui-btn" style="margin-left: 20px" onclick="addToCart()">添加到申购清单</button>
                <button class="layui-btn" style="margin-left: 20px" onclick="viewCart()">
                    查看申购清单
                    <span class="layui-badge" id="cartItemCount"></span>
                </button>
                {{--搜索表单--}}
                {{--<form class="layui-form" style="display:inline-block; max-width: 300px;margin-top: 10px">--}}
                <div class="layui-form-item" style="display:inline-block; max-width: 300px;margin-top: 10px">
                    <label class="layui-form-label">输入搜索</label>
                    <div class="layui-input-block">
                        <input type="text" name="CAS" required lay-verify="required" placeholder="请输入..."
                               autocomplete="off" class="layui-input" oninput="search(this)" value="{{ $search }}">
                    </div>
                </div>
                {{--</form>--}}
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
    <div id="editDiv" style="margin: 10px 20px 20px 30px;">

    </div>
    <div id="cartDiv" style="display: none;padding: 10px">
        <table id="cartTable" lay-filter="cartTable">
        </table>
        <button class="layui-btn" onclick="submitCart()">
            提交申购清单
        </button>
    </div>
@endsection
@section('script')
    <script type="text/html" id="barDemo">
        {{--<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>--}}
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
        //    var $ = layui.$
        var form = layui.form;
        var table = layui.table;
        var cartItemCount = 0;
        table.render({
            elem: '#hazardousChemicals'
            , url: 'hazardousChemicalList?search={{ $search }}'
            , limit: 20
            , page: true //开启分页
            , cols: [[ //表头
                {type: 'checkbox'},
                {field: 'CAS', title: 'CAS'}
                , {field: '中文名', title: '中文名'}
                , {field: '别名', title: '别名'}
                , {field: '备注', title: '备注'}
                , {field: 'hazardousTypeName', title: '种类'}
            ]]
        });

        var cartTable = table.render({
            elem: '#cartTable'
            , url: 'hazardChemCart' //数据接口
            , cols: [[
                {field: 'CAS', title: 'CAS',width:100}
                , {field: '中文名', title: '中文名', width:200}
                , {field: '别名', title: '别名',width:200}
                , {field: 'hazardousTypeName', title: '种类',width:200},
                {fixed: 'right', width:150, align:'center', toolbar: '#barDemo'}
            ]],
            done:function (res, curr, count) {
                cartItemCount = count;
                $("#cartItemCount").html(cartItemCount);
            }
        });

        //监听表格工具条
        table.on('tool(cartTable)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定删除数据么：' + obj.data.中文名, function(index){
                    $.post('deleteHazardChemCartItem',{
                        id:obj.data.id,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },function (d) {
                        layer.msg(d.message);
                        if(d.code === 0){
                            obj.del();
                            cartItemCount -= 1;
                            $("#cartItemCount").html(cartItemCount);
                        }
                    });
                });
            }

        });

        function submitCart() {
            if (cartItemCount === 0){
                layer.msg("清单为空，无法提交")
                return false;
            }
            layer.closeAll();
            window.location.href = "submitCart";
            return false;
        }
        form.on('submit', function (data) {
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

        function viewCart() {
            cartTable.reload();

            layer.open({
                type: 1,
                title: '申购清单',
                area: '876px',
                content: $("#cartDiv")
            });
        }

        function addToCart() {
            var checkStatus = table.checkStatus('hazardousChemicals');
            if (checkStatus.data.length == 0) {
                layer.msg("请至少选择一行")
                return;
            }
            $.ajax({
                type: "POST",
                url: "addItemToHazardChemCart",
                contentType: "application/json; charset=utf-8",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(checkStatus.data),
                success: function (d) {
                    cartTable.reload();
                    layer.msg(d.message);
                }
            });
//            $.post('addItemToHazardChemCart',JSON.stringify(checkStatus.data),function (d) {
//
//            });
//            console.log(checkStatus.data) //获取选中行的数据
//            console.log(checkStatus.data.length) //获取选中行数量，可作为是否有选中行的条件
//            console.log(checkStatus.isAll) //表格是否全选
        }

    </script>
@endsection
