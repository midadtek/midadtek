<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">

	<style>
		@page {
			header: page-header;
			footer: page-footer;
			margin-top: 0.5cm;
			margin-bottom: 0.5cm;
			margin-left: 0.5cm;
			margin-right: 0.5cm;

		}

		/* body {
			font-family: 'droidfont', sans-serif;
			font-size: 12px;
			font-weight: 300;
			border: 5px solid black;
		} */
		#page-border {
			width: 100%;
			height: 100%;
			border: 4px double black;
		}

		.borderdtable,
		.borderdtable th,
		.borderdtable td,
		.info {
			border: 1px solid lightgrey;
			border-collapse: collapse;
			padding-top: 5px;
			padding-bottom: 5px;

		}

		.noborderdtable,
		.noborderdtable th,
		.noborderdtable td {
			padding-top: 5px;
			padding-bottom: 5px;

		}
	</style>
	<style>
		@font-face {
			font-family: 'cairoregular';
			src: url('/storage/resource/cairo-regular-webfont.woff2') format('woff2'),
				url('/storage/resource/cairo-regular-webfont.woff') format('woff');
			font-weight: normal;
			font-style: normal;

		}

		body {
			font-family: 'xbriyaz';
			font-size: 0.9rem;
			font-weight: 300;
			height: 100%;
			width: 100%;
			margin: 0;
			padding: 0;
		}

		body{font-family: 'cairoregular';}
	</style>
</head>

<body>
	<div id="page-border">
		<img style="width: 100px;height:100px;margin-left:610px;" alt="Qries" src="http://project.samhayir.com/storage/resource/Logo-.jpg">

		<h3 style="margin-left: 600px;" >ادارة البرامج والمشاريع</h3>

		
		<div style="text-align: center;">
		@if($statusType == 1)         

		<h4>
			مشاريع لم تبدأ بعد
			</h4>				
				@endif

					@if($statusType == 2)         

					<h4>
			مشاريع جارية
			</h4>					
				@endif

				@if($statusType == 5)         

					<h4>
			مشاريع متأخرة
			</h4>					
				@endif
			
			<h4>
			<span>الفترة من :</span>	<span style="color: red;">{{$from_date}}</span>
			<span>حتى :</span>	<span style="color: red;">{{$to_date}}</span>
			</h4>
			
		</div>

<!-- 
		
		<htmlpagefooter name="page-footer">
			<hr style="border-width:0;color:#e6e6e6;background-color:#e6e6e6">
			

		</htmlpagefooter> -->
		
		<table style="width: 100%; margin-left: auto; margin-right: auto;" class="borderdtable">
			<thead>
				<tr>

					<th style=" text-align: center;"><strong>جهة التنفيذ </strong></th>
				
					@if($statusType == 1)         
					<th style=" text-align: center;"> تاريخ البدء المتوقع</th>
@endif
@if($statusType == 2)         
					<th style=" text-align: center;"> تاريخ النهاية المتوقع</th>
@endif
@if($statusType == 5)         
					<th style=" text-align: center;"> عدد أيام التأخير</th>
@endif
@if($statusType == 5)         
					<th style=" text-align: center;"> مدة التنفيذ</th>
@endif
					<th style=" text-align: center;">قيمة المشروع</th>
                    <th style=" text-align: center;"> الجهة الداعمة</th>

					<th style=" text-align: center;"><strong>اسم المشروع</strong></th>

					<th style=" text-align: center;"><strong>رقم المشروع</strong></th>
					<th style=" text-align: center;"><strong>القطاع</strong></th>

				</tr>
			</thead>
			<tbody>
				@foreach ($projects as $project)
			
				<tr>



					<td style=" text-align: center;">{{$project->office_id ? $project->office->title:'---------'}}</td>
					@if($statusType == 1)         

					<td style=" text-align: center;">{{$project->start_date ? $project->start_date : '------------'}}</td>
					@endif
					@if($statusType == 2)         

					<td style=" text-align: center;">{{$project->start_date ? $project->getFinishedAtDateDependOnDuration($project->start_date,$project->duration_unit,$project->duration) : '---------'}}</td>
					@endif
					@if($statusType == 5)         

					<td style=" text-align: center;">{{$project->start_date ? $project->getTheLateDays($project->getFinishedAtDateDependOnDuration($project->start_date,$project->duration_unit,$project->duration)) : '---------'}}</td>
					@endif
					@if($statusType == 5)         

					<td style=" text-align: center;">   <span>{{$project->duration ? $project->duration : '----------'}}</span> <br><span>{{$project->duration ? $project->getArabUnits($project->duration_unit): '---------'}}</span>  </td>
					@endif

					<td style=" text-align: center;">{{$project->price ? $project->price: '---------'}}  <br> {{$project->currency ? $project->getCurrency($project->currency): '---------'}}</td>
					<td style="text-align: center;">{{$project->supportive_id ? $project->supportive->title: '---------'}}</td>

					<td style=" text-align: center;">{{$project->title ? $project->title:'-------'}}</td>
					<td style=" text-align: center;">{{$project->p_number ? $project->p_number:'------------'}}</td>
					<td style=" text-align: center;">{{$project->section_id ? $project->section->title:'---------'}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<div>
		<table style="width: 100%; margin-left: auto; margin-right: auto;margin-top:50px" class="borderdtable">
			<thead>
				<tr>

				<th style=" text-align: center;"><strong> قيمة اجمالي المشاريع  </strong></th>

				<th style=" text-align: center;"><strong> عدد المشاريع </strong></th>

				

				</tr>
			</thead>
			<tbody>
				<tr>
				

				<td style=" text-align: center;">  {{$project_sum ? $project_sum: '--------'}} <br>دولار</td>

					<td style=" text-align: center;">  {{$projects ? count($projects):'----------'}}</td>


				</tr>

				
			</tbody>
		</table>

		</div>
		<p style="text-align: center;padding: 0px;margin: 0px;font-size: small">
			
				  <span>{{date('d.m.Y')}}</span> 
			
				  <p style="text-align: center;padding: 0px;margin: 0px;font-size: small">
			
				
				  منصة ادارة البرامج والمشاريع</p>
	</p>
	</div>
	<div class="text-center pdf-btn">
        <!-- <button type="button" name="download-pdf" class="btn btn-info download-pdf">Download Pdf</button> -->
    </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</body>

</html>