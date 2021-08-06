<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Laravel 8 PDF File Download using JQuery Ajax Request Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<form id='repForm'>
        <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name">supportives</label>

                                    <select class="form-control select2 supportive" name="supportive_id" id="supportive_id"
                                         >
                                        <option value="" data-unit="">--</option>
                                        @foreach ($supportives as $supportive)
                                        <option value="{{$supportive->id}}">{{$supportive->title}}
                                        </option>
                                      
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name">sections</label>

                                    <select class="form-control select2 section" name="section_id" id="section_id"
                                         >
                                        <option value="" data-unit="">--</option>
                                        @foreach ($sections as $section)
                                        <option value="{{$section->id}}">{{$section->title}}
                                        </option>
                                      
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-2 item_autocomplete">
        <label class="control-label" for="name"></label>

                                    <select class="form-control select2 office" name="office_id" id="office_id"
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

            <label class="control-label" for="name">From Date</label>
            <input type="datetime" class="form-control datepicker" id="from_date" name="from_date" value="07/14/2021 12:00 AM">
        </div>
        <div class="form-group   col-md-2 ">
            <label class="control-label" for="name">To Date</label>
            <input type="datetime" class="form-control datepicker" id="to_date" name="to_date" value="07/14/2021 12:00 AM">
        </div>
        <button type="submit" value="submit" id='submit'>طباعة التقرير</button>
     
    </form>
    @include('pdf.pdf')
    <div class="text-center pdf-btn">
        <button type="button" name="download-pdf" class="btn btn-info download-pdf">Download Pdf</button>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">


$('#repForm').on('submit',function(e){
    e.preventDefault();
    console.log($('#office_id').val());
    let supportive_id = $('#supportive_id').val();
    let section_id = $('#section_id').val();
    let office_id = $('#office_id').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();

    $.ajax({
        type: 'GET',
            url: '/pdf/generate',
      data:{
        "_token": "{{ csrf_token() }}",
        supportive_id:supportive_id,
        section_id:section_id,
        office_id:office_id,
        from_date:from_date,
        to_date:to_date,
      },
      xhrFields: {
                responseType: 'blob'
            },
      success: function(response){
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);

                link.download = "Sample.pdf";
                // window.open(link.download);

                link.click();
            },
            error: function(blob){
                console.log(blob);
            }
     });
    });
  </script>
  <script type="text/javascript">

    $(".download-pdf").click(function(){

        var data = '';
        $.ajax({
            type: 'GET',
            url: '/pdf/generate',
            data: data,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response){
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Sample.pdf";
                link.click();
            },
            error: function(blob){
                console.log(blob);
            }
        });
    });

</script>
</html>