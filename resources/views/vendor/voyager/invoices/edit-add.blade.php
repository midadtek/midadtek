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
        background-color: #43d17f6b;
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
    .items  .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12{
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
</style>
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).'
'.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
<h1 class="page-title">
    <i class="{{ $dataType->icon }}"></i>
    {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
</h1>
@include('voyager::multilingual.language-selector')
@stop

@section('content')
<div class="page-content edit-add container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-bordered panel-success">
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
                            <input type="hidden" name="project_id" value="{{$project_id}}">
                            @endif
                        </div>
                        {{-- items  --}}
                        <div class="row items">
                            <div class="col-md-12 items-title">
                                <div class="form-group  col-md-2">
                                    <label class="control-label">المواد الواردة</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">الوحدة</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">الكمية</label>
                                </div>
                                <div class="form-group  col-md-2">
                                    <label class="control-label">اسم المورد</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">رقم المحضر</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">العملة</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">$ الافرادي</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">$ الكلي</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">ملاحظة</label>
                                </div>
                                <div class="form-group  col-md-1">
                                    <label class="control-label">اضافة\حذف</label>
                                </div>
                            </div>
                            @if($edit)
                            @foreach ($items as $item)
                            <div class="col-md-12 item_added">
                                <div class="form-group  col-md-2 item_autocomplete">
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
                                <div class="form-group  col-md-1">
                                    <input type="number" min="0" class="form-control quantities" name="quantities[]"
                                         value="{{$item->quantities}}" required>
                                </div>
                                <div class="form-group  col-md-2">
                                    <select class="form-control select2" name="supplier_id[]"  required>
                                        <option value="" data-unit="">--</option>
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{$supplier->id}}" @if ($supplier->id==$item->supplier_id)
                                            selected
                                            @endif>{{$supplier->title}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="text" class="form-control" name="receipt_num[]"
                                         value="{{$item->receipt_num}}" required>
                                </div>
                                <div class="form-group  col-md-1">
                                    <select class="form-control select2" name="currency[]"  required>
                                        @foreach ($currencies as $currency)
                                        <option value="{{$currency}}" @if ($currency==$item->currency)
                                            selected
                                            @endif>{{$currency}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="number" min="0" class="form-control individual_price"
                                        name="individual_price[]" 
                                        value="{{$item->individual_price}}">
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="number" min="0" class="form-control total_price" name="total_price[]"
                                         value="{{$item->total_price}}" readonly>
                                </div>
                                <div class="form-group  col-md-1">
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
                                <div class="form-group  col-md-2 item_autocomplete">
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
                                <div class="form-group  col-md-1">
                                    <input type="number" min="0" class="form-control quantities" name="quantities[]"
                                         >
                                </div>
                                <div class="form-group  col-md-2">
                                    <select class="form-control select2" name="supplier_id[]"  >
                                        <option value="" data-unit="">--</option>
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="text" class="form-control" name="receipt_num[]" 
                                        >
                                </div>
                                <div class="form-group  col-md-1">
                                    <select class="form-control select2" name="currency[]"  required>
                                        @foreach ($currencies as $currency)
                                        <option value="{{$currency}}" @if ($loop->first) selected @endif>{{$currency}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="number" min="0" class="form-control individual_price"
                                        name="individual_price[]" >
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="number" min="0" class="form-control total_price" name="total_price[]"
                                         readonly>
                                </div>
                                <div class="form-group  col-md-1">
                                    <input type="text" class="form-control" name="note[]" >
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-success add_item"
                                        style="margin: 0px;"><i class="voyager-plus" voyager-plus></i></button>
                                        <button type="button" class="btn btn-danger btn-sm remove_item"><i
                                            class="voyager-trash" voyager-trash></i></button>
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
    <div class="form-group  col-md-2 item_autocomplete">
        <select class="form-control new-select material required" name="material_id[]"  required>
            <option value="" data-unit="">--</option>
            @foreach ($materials as $material)
            <option value="{{$material->id}}" data-unit="{{$material->unit}}">{{$material->title}} </option>
            @endforeach
        </select>
    </div>
    <div class="form-group  col-md-1">
        <input type="text" class="form-control unit" name="unit[]" disabled>
    </div>
    <div class="form-group  col-md-1">
        <input type="number" min="0" class="form-control quantities" name="quantities[]"  required>
    </div>
    <div class="form-group  col-md-2">
        <select class="form-control new-select required" name="supplier_id[]"  required>
            <option value="" data-unit="">--</option>
            @foreach ($suppliers as $supplier)
            <option value="{{$supplier->id}}">{{$supplier->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group  col-md-1">
        <input type="text" class="form-control required" name="receipt_num[]"  required>
    </div>
    <div class="form-group  col-md-1">
        <select class="form-control new-select" name="currency[]"  required>
            @foreach ($currencies as $currency)
            <option value="{{$currency}}" @if ($loop->first) selected @endif>{{$currency}}
            </option>
            @endforeach
        </select>
    </div>
    <div class="form-group  col-md-1">
        <input type="number" min="0" class="form-control individual_price" name="individual_price[]"
            >
    </div>
    <div class="form-group  col-md-1">
        <input type="number" min="0" class="form-control total_price" name="total_price[]" 
            readonly>
    </div>
    <div class="form-group  col-md-1">
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
        let selectedItem = $(this).val();
        let unit = $('option:selected',this).data("unit");
        $(this).parent().parent().find('.unit').val(unit);
      });
      $(document).on('change', '.individual_price',function(){
        let quantities = $(this).parent().parent().find('.quantities').val();
        let individual_price = $(this).val();
        let total_price = (quantities) ? Math.abs(quantities) * Math.abs(individual_price) : Math.abs(individual_price);
        $(this).parent().parent().find('.total_price').val(total_price);
      });
      $(document).on('change', '.quantities',function(){
        let individual_price = $(this).parent().parent().find('.individual_price').val();
        let quantities = $(this).val();
        let total_price = Math.abs(quantities) * Math.abs(individual_price);
        $(this).parent().parent().find('.total_price').val(total_price);
      });
      $(':input[type="number"]').keyup(function () {
        let oldval = $(this).val();
        $(this).val(Math.abs(oldval));
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