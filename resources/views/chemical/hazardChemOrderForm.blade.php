<div style="padding: 10px">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">申购人姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="申购人姓名" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-inline">
                    <input type="text" name="申购人手机号" required  lay-verify="required|phone" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">身份证号</label>
                <div class="layui-input-inline">
                    <input type="text" name="申购人手机号" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
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
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>


<script>
//form.reload();
form.render();
</script>