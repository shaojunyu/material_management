<div style="padding: 10px">
    <form class="layui-form" id="orderForm" disabled="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"> 负责人</label>
                <div class="layui-input-inline">
                    <input type="text" name="申购人姓名" lay-verify="required"
                           class="layui-input" value="{{$order->fuzeren}}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">申购人姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="申购人姓名" lay-verify="required"
                           class="layui-input" value="{{$order->申购人姓名}}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">申购人手机号</label>
                <div class="layui-input-inline">
                    <input type="text" name="申购人手机号" lay-verify="required|phone"
                           class="layui-input" value="{{$order->申购人手机号}}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">申购人身份证号</label>
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
    </form>
</div>
<script>
    var form = layui.form;
    form.render();
    $('input').attr('disabled', 'disabled');
</script>