{{-- 精神麻醉类化学品表单 --}}
<style>
    .layui-form-label{
        width: 100px;
    }
    .layui-elem-quote{
        border-left:5px solid #FF5722;
    }
</style>
<blockquote class="layui-elem-quote">
    <h4 style="font-weight: bold">{{ $item->中文名 }}</h4>
    <p>精神麻醉类化学品,请按要求填写以下信息，所有字段必须填写</p>
</blockquote>
<div class="layui-inline">
    <label class="layui-form-label">拟供货公司名称</label>
    <div class="layui-input-inline">
        <input type="text" name="{{ $item->id }}拟供货公司名称" value="{{ $item->拟供货公司名称 }}" required  lay-verify="required" class="layui-input">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">公司联系人姓名</label>
    <div class="layui-input-inline">
        <input type="text" name="{{ $item->id }}公司联系人姓名" value="{{ $item->公司联系人姓名 }}" required  lay-verify="required" class="layui-input">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">公司联系人电话</label>
    <div class="layui-input-inline">
        <input type="text" name="{{ $item->id }}公司联系人电话" value="{{ $item->公司联系人电话 }}" required  lay-verify="required" class="layui-input">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">申购数量（升/千克）</label>
    <div class="layui-input-inline">
        <input type="text" name="{{ $item->id }}申购数量" value="{{ $item->申购数量 }}" required  lay-verify="required" class="layui-input">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">危险特性</label>
    <div class="layui-input-inline">
        <input type="text" name="{{ $item->id }}危险特性" value="{{ $item->危险特性 }}" placeholder="易燃、易爆、腐蚀、有毒等" required  lay-verify="required" class="layui-input">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">用途</label>
    <div class="layui-input-inline">
        <input type="text" name="{{ $item->id }}用途" value="{{ $item->用途 }}" required  lay-verify="required" class="layui-input">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">存放地点</label>
    <div class="layui-input-inline">
        <input type="text" name="{{ $item->id }}存放地点" value="{{ $item->存放地点 }}" placeholder="具体到楼号和房间号" required  lay-verify="required" class="layui-input">
    </div>
</div>

<hr>