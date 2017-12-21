<div style="padding: 15px;" id="addCommonChem">
    <form  class="layui-form" action="" lay-filter="CommonChemForm">
        {{ csrf_field() }}
        <!--<div class="layui-form-mid layui-word-aux">带*为必填项</div>-->
        <div class="layui-form-item">
            <label class="layui-form-label">试剂名称*</label>
            <div class="layui-input-block">
                <input disabled type="text" name="试剂名称" required value="{{ $chemical->试剂名称}}"  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">规格*</label>
            <div class="layui-input-block">
                <input disabled type="text" name="规格" required  lay-verify="required" value="{{ $chemical->规格}}"  autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数量*</label>
            <div class="layui-input-block">
                <input disabled id="count" onchange="caculateTotal()" value="{{ $chemical->数量}}" type="text" name="数量" required  lay-verify="required|number" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">单价（元）*</label>
            <div class="layui-input-block">
                <input disabled id="price" onchange="caculateTotal()" value="{{ $chemical->单价}}" type="text" name="单价" required  lay-verify="required|number" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">总金额*</label>
            <div class="layui-input-block">
                <input disabled disabled id="total" type="text" name="总金额" value="{{ $chemical->总金额}}" required  lay-verify="required" autocomplete="off" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申报日期*</label>
            <div class="layui-input-block">
                <input disabled type="text" name="申报日期" required value="{{ $chemical->申报日期}}"  lay-verify="required" autocomplete="off" class="layui-input" id="test1">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申购人姓名*</label>
            <div class="layui-input-block">
                <input disabled type="text" name="申购人姓名" value="{{ $chemical->申购人姓名}}" required  lay-verify="required" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申购人号码*</label>
            <div class="layui-input-block">
                <input disabled type="text" name="申购人号码" value="{{ $chemical->申购人号码}}" required  lay-verify="required|phone" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申购单位</label>
            <div class="layui-input-block">
                {{ $chemical->申购单位}}
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">供应商</label>
            <div class="layui-input-block">
                <input disabled type="text" name="供应商" class="layui-input" value="{{ $chemical->供应商}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">供应商电话</label>
            <div class="layui-input-block">
                <input disabled type="text" name="供应商电话" class="layui-input" value="{{ $chemical->供应商电话}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">经费编号</label>
            <div class="layui-input-block">
                <input disabled type="text" name="经费编号" class="layui-input"  value="{{ $chemical->经费编号}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">经费名称</label>
            <div class="layui-input-block">
                <input disabled type="text" name="经费名称" class="layui-input" value="{{ $chemical->经费名称}}">
            </div>
        </div>
    </form>
</div>