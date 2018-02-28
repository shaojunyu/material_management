<form class="layui-form" action="updateHazardChem" lay-filter="editHahadChem">
    {{ csrf_field() }}
    <input hidden name="id" value="{{$chemical->id}}">
    <div class="layui-form-mid layui-word-aux">带*为必填项</div>
    <div class="layui-form-item">
        <label class="layui-form-label">CAS号*</label>
        <div class="layui-input-block">
            <input type="text" name="CAS" required lay-verify="required" placeholder="请输入CAS号"
                   autocomplete="off" class="layui-input" value="{{$chemical->CAS}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">中文名*</label>
        <div class="layui-input-inline">
            <input type="text" name="中文名" required lay-verify="required" placeholder="请输入中文名" autocomplete="off"
                   class="layui-input" value="{{ $chemical->中文名 }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">种类</label>
        <div class="layui-input-block">
            <select name="hazardous_type" lay-verify="required">.
                <option value="1" {{$chemical->hazardous_type===1?'selected':''}}>剧毒化学品</option>
                <option value="2" {{$chemical->hazardous_type===2?'selected':''}}>易制毒化学品</option>
                <option value="3" {{$chemical->hazardous_type===3?'selected':''}}>易制爆化学品</option>
                <option value="4" {{$chemical->hazardous_type===4?'selected':''}}>精神麻醉类化学品</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">别名</label>
        <div class="layui-input-inline">
            <input type="text" name="别名" placeholder="" autocomplete="off" class="layui-input"
                   value="{{$chemical->别名}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-inline">
            <input type="text" name="备注" placeholder="" value="{{$chemical->备注}}" autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit>立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    form.render();
</script>