{{-- 易制毒化学品表单 --}}
<div class="bs-callout bs-callout-warning">
    <h4>{{ $item->中文名 }}</h4>
    <p>易制毒化学品,请按要求填写以下信息，所有字段必须填写</p>
</div>
<div class="bjui-row col-2">
    <label class="row-label">拟供货公司名称</label>
    <div class="row-input required">
        <input type="text" name="{{ $item->id }}拟供货公司名称" value="{{ $item->拟供货公司名称 }}" data-rule="required">
    </div>
    <label class="row-label">公司联系人姓名</label>
    <div class="row-input required">
        <input type="text" name="{{ $item->id }}公司联系人姓名" value="{{ $item->公司联系人姓名 }}" data-rule="required">
    </div>
    <label class="row-label">公司联系人电话</label>
    <div class="row-input required">
        <input type="text" name="{{ $item->id }}公司联系人电话" value="{{ $item->公司联系人电话 }}" data-rule="required;mobile">
    </div>
    <label class="row-label">申购数量（升/千克）</label>
    <div class="row-input required">
        <input type="text" name="{{ $item->id }}申购数量" value="{{ $item->申购数量 }}" data-rule="required">
    </div>
    <label class="row-label">用途</label>
    <div class="row-input required">
        <input type="text" name="{{ $item->id }}用途" value="{{ $item->用途 }}" data-rule="required">
    </div>
</div>
