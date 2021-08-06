@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
<div class="container-fluid">
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
    </h1>
    <a href="{{route('voyager.reports.print_all', array('project_ids'=>'1'))}}" title="طباعة التقرير" target="_blank" class="btn btn-sm btn-primary">
        <i class="voyager-file-text"></i> <span class="hidden-xs hidden-sm">طباعة التقرير</span>
    </a>
    <a href="{{route('voyager.reports.export_all', array('project_ids'=>'1'))}}" title="تصدير التقرير" target="_blank" class="btn btn-sm btn-primary">
        <i class="voyager-list"></i> <span class="hidden-xs hidden-sm">تصدير التقرير</span>
    </a>
    @can('add', app($dataType->model_name))
    <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
        <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
    </a>
    @endcan
    @can('delete', app($dataType->model_name))
    @include('voyager::partials.bulk-delete')
    @endcan
    @can('edit', app($dataType->model_name))
    @if(isset($dataType->order_column) && isset($dataType->order_display_column))
    <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary btn-add-new">
        <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
    </a>
    @endif
    @endcan
    @can('delete', app($dataType->model_name))
    @if($usesSoftDeletes)
    <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}" data-off="{{ __('voyager::bread.soft_deletes_on') }}">
    @endif
    @endcan
    @foreach($actions as $action)
    @if (method_exists($action, 'massAction'))
    @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
    @endif
    @endforeach
    @include('voyager::multilingual.language-selector')
</div>
@stop

@section('content')
<div class="page-content browse container-fluid">
<!-- voyager.reports.sub -->
    <form id='supportiveForm'>
        <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name">الجهة الداعمة</label>

        <select required class="form-control select2 supportive" name="supportive_id" id="supportive_id"
                                         >
                                        <option value="" data-unit="">--</option>
                                        @foreach ($supportives as $supportive)
                                        <option value="{{$supportive->id}}">{{$supportive->title}}
                                        </option>
                                      
                                        @endforeach
                                    </select>
                                </div>
                              
                           
                                <!-- <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Enter subject" id="subject">
        </div> -->
        
       
        <div class="form-group   col-md-2 ">

            <label class="control-label" for="name">من التاريخ </label>
            <input type="datetime" class="form-control datepicker" id="from_date" name="from_date">
        </div>
        <div class="form-group   col-md-2 ">
            <label class="control-label" for="name">الى التاريخ </label>
            <input type="datetime" class="form-control datepicker" id="to_date" name="to_date" >
        </div>
        <input type="hidden" class="form-control" id="formType" name="formType" value="1">
        <div class="form-group   col-md-2 " style="margin-top: 30px;">
        <button class="btn btn-sm btn-primary" type="submit" value="pdf" id='submit'>طباعة التقرير</button>
        <button  class="btn btn-sm btn-primary"  type="submit" value="excel">Excel</button>



        </div>
     
    </form>
   

</div>




<div class="page-content browse container-fluid">
<form id='sectionForm'>
        
        <div class="form-group  col-md-2 item_autocomplete">
<label class="control-label" for="name">القطاعات</label>

<select required class="form-control select2 section" name="section_id" id="section_id"
                 >
                <option value="" data-unit="">--</option>
                @foreach ($sections as $section)
                <option value="{{$section->id}}">{{$section->title}}
                </option>
              
                @endforeach
            </select>
        </div>
       



<div class="form-group   col-md-2 ">

<label class="control-label" for="name">من التاريخ</label>
<input type="datetime" class="form-control datepicker" id="from_date1" name="from_date">
</div>
<div class="form-group   col-md-2 ">
<label class="control-label" for="name">الى التاريخ</label>
<input type="datetime" class="form-control datepicker" id="to_date1" name="to_date" >
</div>
<input type="hidden" class="form-control" id="formType1" name="formType" value="2">

<div class="form-group   col-md-2 " style="margin-top: 30px;">
        <button class="btn btn-sm btn-primary" type="submit" value="pdf" id='submit'>طباعة التقرير</button>
        <button  class="btn btn-sm btn-primary"  type="submit" value="excel">Excel</button>

        </div>
</form>
</div>





<div class="page-content browse container-fluid">
<!-- voyager.reports.sub -->
    <form id='officeForm'>
      
                              
                                <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name">جهات التنفيذ</label>
        <select required class="form-control select2 office" name="office_id" id="office_id"
                                         >
                                        <option value="" data-unit="">--</option>
                                        @foreach ($offices as $office)
                                        <option value="{{$office->id}}">{{$office->title}}
                                        </option>
                                      
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Enter subject" id="subject">
        </div> -->
        
       
        <div class="form-group   col-md-2 ">

            <label class="control-label" for="name">من التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="from_date3" name="from_date">
        </div>
        <div class="form-group   col-md-2 ">
            <label class="control-label" for="name">الى التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="to_date3" name="to_date" >
        </div>
        <input type="hidden" class="form-control" id="formType3" name="formType" value="3">

        <div class="form-group   col-md-2 " style="margin-top: 30px;">
        <button class="btn btn-sm btn-primary" type="submit" value="pdf" id='submit'>طباعة التقرير</button>
        <button  class="btn btn-sm btn-primary"  type="submit" value="excel">Excel</button>

        </div>     
    </form>
   

</div>
<div class="page-content browse container-fluid">
<!-- voyager.reports.sub -->
    <form id='projectdidntstartForm'>
      
                              
                                <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name">حالة المشروع</label>
        <select required class="form-control select2 status" name="status" id="status"
                                         >
                                        <option value="" data-unit="">--</option>
                                        <option value="1">لم يبدأ بعد
                                        </option>
                                        <option value="2">جاري العمل فيه
                                        </option>
                                        <option value="5">متأخر عن الوقت المحدد
                                        </option>
                                      
                                    </select>
                                </div>
                                <!-- <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Enter subject" id="subject">
        </div> -->
        
       
        <div class="form-group   col-md-2 ">

            <label class="control-label" for="name">من التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="from_date4" name="from_date">
        </div>
        <div class="form-group   col-md-2 ">
            <label class="control-label" for="name">الى التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="to_date4" name="to_date" >
        </div>
        <input type="hidden" class="form-control" id="formType4" name="formType" value="4">

        <div class="form-group   col-md-2 " style="margin-top: 30px;">
        <button  class="btn btn-sm btn-primary" type="submit" value="pdf" id='submit'>طباعة التقرير</button>
        <button  class="btn btn-sm btn-primary"  type="submit" value="excel">Excel</button>

        </div>     
    </form>
   

</div>


<div class="page-content browse container-fluid">
<!-- voyager.reports.sub -->
    <form id='projectDependOnEngineer'>
      
                              
                                <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name"> المهندس</label>
        <select required class="form-control select2 user" name="user_id" id="user_id"
                                         >
                                        <option value="" data-unit="">--</option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}
                                        </option>
                                      
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Enter subject" id="subject">
        </div> -->
        
       
        <div class="form-group   col-md-2 ">

            <label class="control-label" for="name">من التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="from_date5" name="from_date">
        </div>
        <div class="form-group   col-md-2 ">
            <label class="control-label" for="name">الى التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="to_date5" name="to_date" >
        </div>
        <input type="hidden" class="form-control" id="formType5" name="formType" value="5">

        <div class="form-group   col-md-2 " style="margin-top: 30px;">
        <button  class="btn btn-sm btn-primary" type="submit" value="pdf" id='submit'>طباعة التقرير</button>
        <button  class="btn btn-sm btn-primary"  type="submit" value="excel">Excel</button>

        </div>     
    </form>
   

</div>


<div class="page-content browse container-fluid">
<!-- voyager.reports.sub -->
    <form id='projectDependOnManager'>
      
                              
                                <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name"> المدير</label>
        <select required class="form-control select2 manager" name="manager_id" id="manager_id"
                                         >
                                        <option value="" data-unit="">--</option>
                                        @foreach ($managers as $manager)
                                        <option value="{{$manager->id}}">{{$manager->name}}
                                        </option>
                                      
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Enter subject" id="subject">
        </div> -->
        
       
        <div class="form-group   col-md-2 ">

            <label class="control-label" for="name">من التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="from_date6" name="from_date">
        </div>
        <div class="form-group   col-md-2 ">
            <label class="control-label" for="name">الى التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="to_date6" name="to_date" >
        </div>
        <input type="hidden" class="form-control" id="formType6" name="formType" value="6">

        <div class="form-group   col-md-2 " style="margin-top: 30px;">
        <button  class="btn btn-sm btn-primary" type="submit" value="pdf" id='submit'>طباعة التقرير</button>
        <button  class="btn btn-sm btn-primary"  type="submit" value="excel">Excel</button>

        </div>     
    </form>
   

</div>



<div class="page-content browse container-fluid">
<!-- voyager.reports.sub -->
    <form id='projectDependOnCountry'>
      
                              
                                <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name"> الدولة</label>
        <select required class="form-control select2 country" name="country_id" id="country_id"
                                         >
                                         <option value="" data-unit="">--</option>
                                        <option value="1">سوريا
                                        </option>
                                        <option value="2">تركيا
                                        </option>
                                     
                                      
                                    </select>
                                </div>
                                <!-- <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Enter subject" id="subject">
        </div> -->
        
       
        <div class="form-group   col-md-2 ">

            <label class="control-label" for="name">من التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="from_date7" name="from_date">
        </div>
        <div class="form-group   col-md-2 ">
            <label class="control-label" for="name">الى التاريخ</label>
            <input type="datetime" class="form-control datepicker" id="to_date7" name="to_date" >
        </div>
        <input type="hidden" class="form-control" id="formType7" name="formType" value="7">

        <div class="form-group   col-md-2 " style="margin-top: 30px;">
        <button  class="btn btn-sm btn-primary" type="submit" value="pdf" id='submit'>طباعة التقرير</button>
        <button  class="btn btn-sm btn-primary"  type="submit" value="excel">Excel</button>

        </div>     
    </form>
   

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
      $("#supportiveForm button").click(function (ev) {
      ev.preventDefault()
     if ($(this).attr("value") == "pdf") {            
        // alert("First Button is pressed - Form will submit")
        let supportive_id = $('#supportive_id').val();
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();
        let formType = $('#formType').val();

        
        let url= "/report/printPdf";
        $.ajax({
            type: 'POST',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            supportive_id:supportive_id,
            from_date:from_date,
            to_date:to_date,
            formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
                
            var blob = new Blob([response], {type: 'application/pdf'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);

                            var w= window.open(link.href);
                                            console.log(blob)
                                            // document.getElementById("supportiveForm").reset();

            
                                            // location.reload();               
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
            $("#supportiveForm").submit();
        }
        if ($(this).attr("value") == "excel") {
            let supportive_id = $('#supportive_id').val();
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();
        let formType = $('#formType').val();

        
        let url= "/report/exportExcel";
        $.ajax({
            type: 'GET',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            supportive_id:supportive_id,
            from_date:from_date,
            to_date:to_date,
            formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
            var blob = new Blob([response], {type: 'application/xlsx'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);
                            // link.download();
                            link.download = "حسب الجهة الداعمة.xlsx";
                            link.click();
        
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    // alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
        }
        });









        $("#sectionForm button").click(function (ev) {
      ev.preventDefault()
     if ($(this).attr("value") == "pdf") {            
        // alert("First Button is pressed - Form will submit")
        let section_id = $('#section_id').val();
    let from_date = $('#from_date1').val();
    let to_date = $('#to_date1').val();
    let formType = $('#formType1').val();

        
        let url= "/report/printPdf";
        $.ajax({
            type: 'POST',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            section_id:section_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
                
            var blob = new Blob([response], {type: 'application/pdf'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);

                            var w= window.open(link.href);
                                            console.log(blob)
                                            // document.getElementById("supportiveForm").reset();

            
                                            // location.reload();               
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
            $("#sectionForm").submit();
        }
        if ($(this).attr("value") == "excel") {
            let section_id = $('#section_id').val();
    let from_date = $('#from_date1').val();
    let to_date = $('#to_date1').val();
    let formType = $('#formType1').val();

        
        let url= "/report/exportExcel";
        $.ajax({
            type: 'GET',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            section_id:section_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
            var blob = new Blob([response], {type: 'application/xlsx'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);
                            // link.download();
                            link.download = "حسب القطاع.xlsx";
                            link.click();
        
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    // alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
        }
        });
















        $("#officeForm button").click(function (ev) {
      ev.preventDefault()
     if ($(this).attr("value") == "pdf") {            
        // alert("First Button is pressed - Form will submit")
        let office_id = $('#office_id').val();
    let from_date = $('#from_date3').val();
    let to_date = $('#to_date3').val();
    let formType = $('#formType3').val();

        
        let url= "/report/printPdf";
        $.ajax({
            type: 'POST',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            office_id:office_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
                
            var blob = new Blob([response], {type: 'application/pdf'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);

                            var w= window.open(link.href);
                                            console.log(blob)
                                            // document.getElementById("supportiveForm").reset();

            
                                            // location.reload();               
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
            $("#officeForm").submit();
        }
        if ($(this).attr("value") == "excel") {
            let office_id = $('#office_id').val();
    let from_date = $('#from_date3').val();
    let to_date = $('#to_date3').val();
    let formType = $('#formType3').val();

        
        let url= "/report/exportExcel";
        $.ajax({
            type: 'GET',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            office_id:office_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
            var blob = new Blob([response], {type: 'application/xlsx'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);
                            // link.download();
                            link.download = "حسب جهات التنفيذ.xlsx";
                            link.click();
        
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    // alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
        }
        });







        $("#projectdidntstartForm button").click(function (ev) {
      ev.preventDefault()
     if ($(this).attr("value") == "pdf") {            
        let status =parseInt($('#status').val());
    console.log(status);
    let from_date = $('#from_date4').val();
    let to_date = $('#to_date4').val();
    let formType = $('#formType4').val();

        
        let url= "/report/printPdf";
        $.ajax({
            type: 'POST',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            status:   status,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
                
            var blob = new Blob([response], {type: 'application/pdf'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);

                            var w= window.open(link.href);
                                            console.log(blob)
                                            // document.getElementById("supportiveForm").reset();

            
                                            // location.reload();               
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
            $("#projectdidntstartForm").submit();
        }
        if ($(this).attr("value") == "excel") {
            let status =parseInt($('#status').val());
    console.log(status);
    let from_date = $('#from_date4').val();
    let to_date = $('#to_date4').val();
    let formType = $('#formType4').val();

        
        let url= "/report/exportExcel";
        $.ajax({
            type: 'GET',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            status:   status,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
            var blob = new Blob([response], {type: 'application/xlsx'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);
                            // link.download();
                            link.download = "حسب حالة المشروع.xlsx";
                            link.click();
        
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    // alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
        }
        });





        $("#projectDependOnEngineer button").click(function (ev) {
      ev.preventDefault()
     if ($(this).attr("value") == "pdf") {            
        let user_id = $('#user_id').val();
    let from_date = $('#from_date5').val();
    let to_date = $('#to_date5').val();
    let formType = $('#formType5').val();

        
        let url= "/report/printPdf";
        $.ajax({
            type: 'POST',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            user_id:   user_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
                
            var blob = new Blob([response], {type: 'application/pdf'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);

                            var w= window.open(link.href);
                                            console.log(blob)
                                            // document.getElementById("supportiveForm").reset();

            
                                            // location.reload();               
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
            $("#projectDependOnEngineer").submit();
        }
        if ($(this).attr("value") == "excel") {
            let user_id = $('#user_id').val();
    let from_date = $('#from_date5').val();
    let to_date = $('#to_date5').val();
    let formType = $('#formType5').val();

        
        let url= "/report/exportExcel";
        $.ajax({
            type: 'GET',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            user_id:   user_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
            var blob = new Blob([response], {type: 'application/xlsx'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);
                            // link.download();
                            link.download = "حسب المهندس.xlsx";
                            link.click();
        
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    // alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
        }
        });






        $("#projectDependOnManager button").click(function (ev) {
      ev.preventDefault()
     if ($(this).attr("value") == "pdf") {            
        let manager_id = $('#manager_id').val();
    let from_date = $('#from_date6').val();
    let to_date = $('#to_date6').val();
    let formType = $('#formType6').val();

        
        let url= "/report/printPdf";
        $.ajax({
            type: 'POST',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            manager_id:   manager_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
                
            var blob = new Blob([response], {type: 'application/pdf'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);

                            var w= window.open(link.href);
                                            console.log(blob)
                                            // document.getElementById("supportiveForm").reset();

            
                                            // location.reload();               
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
            $("#projectDependOnManager").submit();
        }
        if ($(this).attr("value") == "excel") {
            let manager_id = $('#manager_id').val();
    let from_date = $('#from_date6').val();
    let to_date = $('#to_date6').val();
    let formType = $('#formType6').val();

        
        let url= "/report/exportExcel";
        $.ajax({
            type: 'GET',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            manager_id:   manager_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
            var blob = new Blob([response], {type: 'application/xlsx'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);
                            // link.download();
                            link.download = "حسب المدير.xlsx";
                            link.click();
        
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    // alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
        }
        });




        $("#projectDependOnCountry button").click(function (ev) {
      ev.preventDefault()
     if ($(this).attr("value") == "pdf") {            
        let country_id = $('#country_id').val();
    let from_date = $('#from_date7').val();
    let to_date = $('#to_date7').val();
    let formType = $('#formType7').val();

        
        let url= "/report/printPdf";
        $.ajax({
            type: 'POST',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            country_id:   country_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
                
            var blob = new Blob([response], {type: 'application/pdf'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);

                            var w= window.open(link.href);
                                            console.log(blob)
                                            // document.getElementById("supportiveForm").reset();

            
                                            // location.reload();               
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
            $("#projectDependOnCountry").submit();
        }
        if ($(this).attr("value") == "excel") {
            let country_id = $('#country_id').val();
    let from_date = $('#from_date7').val();
    let to_date = $('#to_date7').val();
    let formType = $('#formType7').val();

        
        let url= "/report/exportExcel";
        $.ajax({
            type: 'GET',
                url: url,
        data:{
            "_token": "{{ csrf_token() }}",
            country_id:   country_id,
        from_date:from_date,
        to_date:to_date,
        formType:formType
        },
        xhrFields: {
                    responseType: 'blob'
                },
        success: function(response){
            console.log(response);
            var blob = new Blob([response], {type: 'application/xlsx'});
                var link = document.createElement('a');

                            link.href = window.URL.createObjectURL(blob);
                            // link.download();
                            link.download = "حسب الدولة.xlsx";
                            link.click();
        
                },
                error: function(blob){
                    console.log(blob);
                    // document.getElementById("supportiveForm").reset();
                    // location.reload();
                    // alert('لا يوجد تقرير بالمعلومات المدخلة');


                }
        });
        }
        });

        
});
</script>

   <script type="text/javascript">



    
  </script>
@stop