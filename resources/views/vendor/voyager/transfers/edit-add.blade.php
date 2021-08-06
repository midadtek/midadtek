@php
$edit = !is_null($dataTypeContent->getKey());
$add = is_null($dataTypeContent->getKey());
@endphp
@extends('voyager::master')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .voyager input[type=file] {
        padding: 6px !important;
    }
    .headering {
        background-color: #5d43d16b;
        padding-top: 10px;
        margin-top: -15px;
    }
    .items-title{
        background-color: aliceblue;
        text-align: center;
    }
    .form-group{
        /* outline: gray 1px solid; */
            margin-bottom: 0px;
    }
    .btn-sm{
        padding: 1px 6px;
    }
</style>
@stop
@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).'
'.$dataType->getTranslatedAttribute('display_name_singular'))
@section('page_header')
<h1 class="page-title">
    {{ ($edit) ? 'تعديل محضر النقل  ' : 'إضافة محضر نقل  ' }} <span style="color: red">{{' '.$project->title}}</span>
</h1>
@include('voyager::multilingual.language-selector')
@stop
@section('content')
<div class="page-content edit-add container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered panel-info">
                <!-- form start -->
                <form role="form" class="form-edit-add"
                    action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                    method="POST" enctype="multipart/form-data">
                    <!-- PUT Method if we are editing -->
                    @if($edit)
                    {{ method_field("PUT") }}
                    @endif
                    <!-- CSRF TOKEN -->
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="row headering">
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <!-- Adding / Editing -->
                            @php
                            $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp
                            @foreach($dataTypeRows as $row)
                            <!-- GET THE DISPLAY OPTIONS -->
                            @php
                            $display_options = $row->details->display ?? NULL;
                            if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' :
                            'add')};
                            }
                            @endphp
                            @if (isset($row->details->legend) && isset($row->details->legend->text))
                            <legend class="text-{{ $row->details->legend->align ?? 'center' }}"
                                style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">
                                {{ $row->details->legend->text }}</legend>
                            @endif
                            <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}"
                                @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                {{ $row->slugify }}
                                <label class="control-label"
                                    for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                @include('voyager::multilingual.input-hidden-bread-edit-add')
                                @if (isset($row->details->view))
                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent'
                                =>
                                $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ?
                                'edit'
                                : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                @elseif ($row->type == 'checkbox')
                                @if (in_array(Illuminate\Support\Facades\Auth::user()->role->id ,['1' ,'7', '4']) )
                                    @include('voyager::formfields.checkbox', ['options' => $row->details])
                                @endif
                                @elseif ($row->type == 'relationship')
                                @include('voyager::formfields.relationship', ['options' => $row->details])
                                @else
                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                @endif
                                @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                @endforeach
                                @if ($errors->has($row->field))
                                @foreach ($errors->get($row->field) as $error)
                                <span class="help-block">{{ $error }}</span>
                                @endforeach
                                @endif
                            </div>
                            @endforeach
                            @if ($add)
                            <input type="hidden" name="project_id" value="{{$project->id}}">                            
                            @endif
                        </div>
                        {{-- items  --}}
                        <div class="row items">
                            <div class="col-md-12 items-title">
                                <div class="form-group  col-md-3">
                                    <label class="control-label">المادة</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">الوحدة</label>
                                </div>
                                <div class="form-group  col-md-2">
                                    <label class="control-label">الكمية</label>
                                </div>
                                <div class="form-group  col-md-2">
                                    <label class="control-label">السعر</label>
                                </div>
                                <div class="form-group  col-md-3">
                                    <label class="control-label">ملاحظة</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">اضافة\حذف</label>
                                </div>
                            </div>
                            @if($edit)
                            @foreach ($items as $item)
                            <div class="col-md-12 item_added">
                                <div class="form-group  col-md-3 item_autocomplete">
                                    <select class="form-control select2 material" name="material_id[]"
                                         required>
                                        <option value="" data-unit="">--</option>
                                        @foreach ($materials as $material)
                                        <option value="{{$material->id}}" @if ($material->id == $item->material_id)
                                            selected
                                            @endif data-unit="{{$material->unit}}">{{$material->title}}
                                        </option>
                                        @php
                                        if ($material->id == $item->material_id) {$unit = $material->unit;}
                                        @endphp
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="text" class="form-control unit" name="unit[]" 
                                        value="{{ $unit }}" disabled>
                                </div>
                                <div class="form-group  col-md-2">
                                    <input type="number" min="0" class="form-control quantities" name="quantities[]"
                                         value="{{$item->quantities}}" required>
                                </div>
                                <div class="form-group  col-md-2">
                                    <input type="number" class="form-control price" name="price[]" value="{{$item->price}}" readonly>                                    
                                </div>
                                <div class="form-group  col-md-3">
                                    <input type="text" class="form-control" name="note[]" 
                                        value="{{$item->note}}">
                                </div>
                                
                                <input type="hidden" class="form-control" name="id[]" value="{{$item->id}}">
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-success add_item"
                                        style="margin: 0px;"><i class="voyager-plus" voyager-plus></i></button>
                                    <button type="button" class="btn btn-danger btn-sm remove_item"><i
                                            class="voyager-trash" voyager-trash></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="col-md-12">
                                <div class="form-group  col-md-3 item_autocomplete">
                                    <select class="form-control select2 material" name="material_id[]"
                                         >
                                        <option value="" data-unit="">--</option>
                                        @foreach ($materials as $material)
                                        <option value="{{$material->id}}" data-unit="{{$material->unit}}">
                                            {{$material->title}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="text" class="form-control unit" name="unit[]" disabled>
                                </div>
                                <div class="form-group  col-md-2">
                                    <input type="number" min="0" class="form-control quantities" name="quantities[]"
                                         >
                                </div>
                                <div class="form-group  col-md-2">
                                    <input type="number" class="form-control price" name="price[]" readonly>
                                    <input type="hidden" class="currency" name="currency[]">
                                </div>
                                <div class="form-group  col-md-3">
                                    <input type="text" class="form-control" name="note[]" >
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-success add_item"
                                        style="margin: 0px;"><i class="voyager-plus" voyager-plus></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" disabled><i class="voyager-trash"
                                            voyager-trash></i></button>
                                </div>
                            </div>
                        </div>
                        {{-- end items  --}}
                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        @section('submit-buttons')
                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                        @stop
                        @yield('submit-buttons')
                    </div>
                </form>
                <iframe id="form_target" name="form_target" style="display:none"></iframe>
                <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                    enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                    <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
                    <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-danger" id="confirm_delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
            </div>
            <div class="modal-body">
                <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                <button type="button" class="btn btn-danger"
                    id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- End Delete File Modal -->
<!-- new Item Modal -->
<div class="item_element" style="display: none">
    <div class="form-group  col-md-3 item_autocomplete">
        <select class="form-control new-select material" name="material_id[]"  required>
            <option value="" data-unit="">--</option>
            @foreach ($materials as $material)
            <option value="{{$material->id}}" data-unit="{{$material->unit}}">{{$material->title}} </option>
            @endforeach
        </select>
    </div>
    <div class="form-group  col-md-1">
        <input type="text" class="form-control unit" name="unit[]" disabled>
    </div>
    <div class="form-group  col-md-2">
        <input type="number" min="0" class="form-control quantities" name="quantities[]"  required>
    </div>
    <div class="form-group  col-md-2">
        <input type="number" class="form-control price" name="price[]" readonly>
        <input type="hidden" class="currency" name="currency[]">
    </div>
    <div class="form-group  col-md-3">
        <input type="text" class="form-control" name="note[]" >
    </div>
    <div class="form-group  col-md-1">
        <button type="button" class="btn btn-sm btn-success add_item" style="margin: 0px;"><i class="voyager-plus"
                voyager-plus></i></button>
        <button type="button" class="btn btn-danger btn-sm remove_item"><i class="voyager-trash"
                voyager-trash></i></button>
    </div>
</div>
<!-- End new Item Modal -->

@stop
@section('javascript')
<script>
    {{Cookie::queue('project_id', $project->id, 1)}}
    var params = {};
        var $file;
        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);
            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }
            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }
        // items operations
        
      $(document).on('change', '.material',function(){
        //   let tproject_id = $('select[name="tproject_id"]').val();
        //   if (tproject_id) {
        //     console.log(tproject_id); 
        //   }else{
        //     console.log('not'); 
        //   }
        let project_id = {{$project->id}}; 
        console.log(project_id);  
        let selectedItem = $(this).val();
        let unit = $('option:selected',this).data("unit");
        $(this).parent().parent().find('.unit').val(unit);
        $(this).parent().parent().find('.price').val('');
        $(this).parent().parent().find('.quantities').val('');
      });
      $(document).on('change', '.quantities',function(){
        let that = $(this);
        let material_id = $(this).parent().parent().find('.material').val();
        let price = $(this).parent().parent().find('.price');
        let currency = $(this).parent().parent().find('.currency');
        let quantities = $(this).val();
        $.ajax({
            type:'Get',
            url:"{{ route('voyager.checkQuantities') }}",
            data:{_token: '{{ csrf_token() }}',project_id:'{{$project->id}}',material_id:material_id},
            success:function(data){
                if(data){
                    if(data.avaliable < 0){
                        alert('هذه المادة غير متوفرة في المشروع');
                        that.val(0);
                        price.val(0);
                    }
                    else if (data.avaliable < quantities) {
                        alert('الكمية المتوفرة ('+data.avaliable+') اقل من القيمة المدخلة('+quantities+') يرجى التحقق من الادخال');
                        that.val(data.avaliable);
                        price.val(data.price);
                        currency.val(data.currency);
                    }
                    else{
                        price.val(data.price);
                        currency.val(data.currency);
                    }
                }
            }
        });
      });
      
      
      
      // end item operations
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });
            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif
            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });
            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));
            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {
                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });
                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
</script>
@stop