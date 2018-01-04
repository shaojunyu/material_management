@extends('layouts.admin')
@section('main-body')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote">
                危险化学药品申购--信息完善，订单业务号：{{ $order->id  }}
                {{--<button class="layui-btn" style="margin-left: 20px" onclick="openAddForm()">添加危险化学品</button>--}}
            </blockquote>
            <div style="padding: 10px">
                <form class="layui-form" id="orderForm" action="submitOrder" method="post">
                    <input hidden name="order_id" value="{{$order->id}}">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">负责人姓名</label>
                            <div class="layui-input-inline">
                                <input type="text" name="申购人姓名" lay-verify="required"
                                       class="layui-input" value="{{$order->申购人姓名}}">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">手机号</label>
                            <div class="layui-input-inline">
                                <input type="text" name="申购人手机号" lay-verify="required|phone"
                                       class="layui-input" value="{{$order->申购人手机号}}">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">身份证号</label>
                            <div class="layui-input-inline">
                                <input type="text" name="申购人身份证号" lay-verify="required|identity"
                                       class="layui-input" value="{{$order->申购人身份证号}}">
                            </div>
                        </div>
                    </div>

                    @foreach ($items as $item)
                        @if ($item->hazardousTypeName === '剧毒化学品')
                            @include('chemical.judu',['item'=>$item])
                        @elseif ($item->hazardousTypeName === '易制毒化学品')
                            @include('chemical.zhidu',['item'=>$item])
                        @elseif ($item->hazardousTypeName === '易制爆化学品')
                            @include('chemical.zhibao',['item'=>$item])
                        @elseif ($item->hazardousTypeName === '精神麻醉类化学品')
                            @include('chemical.jingshen',['item'=>$item])
                        @else
                            其他
                        @endif
                    @endforeach

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn layui-btn-warm" onclick="storeOrder()">保存信息</button>
                            <button class="layui-btn" lay-submit lay-filter="*" id="submitButton">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
                <hr>
                <p>
                    点击"保存信息"会保存表单当前信息，下次可继续编辑<br>
                    点击"立即提交"会保存表单信息，并提交管理员审核
                </p>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var form = layui.form;
        form.render();

        function storeOrder() {
            index = layer.load(2);
            $.ajax({
                type: "POST",
                url: "storeOrder",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $("#orderForm").serialize(),
                success: function (d) {
                    layer.close(index);
                    layer.msg(d.message, {icon: 1,time:2*1000});
                }
            });
            event.preventDefault();
            return false;
        }

        form.on('submit(*)', function (data) {
            layer.confirm('确认提交吗？提交后将无法修改信息，等待管理员审核！', {
                btn: ['提交', '取消'],
                yes: function (index) {
                    layer.closeAll();
                    index = layer.load(2);
                    $.ajax({
                        type: "POST",
                        url: "submitOrder",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: $("#orderForm").serialize(),
                        success: function (d) {
                            layer.close(index);
                            layer.msg(d.message, {icon: 1});
                            setTimeout(function () {
                                window.location.href = 'HazardousChemicalOrder';
                            },1500)
                        }
                    });
                },
                btn2: function () {
                    layer.closeAll();
                    return false;
                }
            });
            return false;
        });
    </script>
@endsection