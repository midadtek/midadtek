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
		<div style="text-align:right;">
		<h3>جمعية شام الخير</h3>
		<h3>ادارة البرامج والمشاريع</h3>


		</div>
		<div style="text-align: center;">
			<h4>
			مشاريع حسب الجهة الداعمة :	<span style="color: red;">{{$supTitle}}</span>
			</h4>
		</div>
		<htmlpagefooter name="page-footer">
			<hr style="border-width:0;color:#e6e6e6;background-color:#e6e6e6">
			<p style="text-align: center;padding: 0px;margin: 0px;font-size: small">
			
				 -  <span>{{date('d.m.Y')}}</span></p>

		</htmlpagefooter>
		
		<table style="width: 100%; margin-left: auto; margin-right: auto;" class="borderdtable">
			<thead>
				<tr>
					<th style="width: 15%; text-align: center;"><strong>القطاع</strong></th>
					<th style="width: 20%; text-align: center;"><strong>جهة التنفيذ </strong></th>
					<td style="width: 5%; text-align: center;">قيمة المشروع</td>

					<th style="width: 30%; text-align: center;"><strong>اسم المشروع</strong></th>

					<th style="width: 25%; text-align: center;"><strong>رقم المشروع</strong></th>

				</tr>
			</thead>
			<tbody>
				@foreach ($projects as $project)
				<tr>
					<th style="width: 15%; text-align: center;">{{$project->doner_name}}</td>
					<th style="width: 20%; text-align: center;">{{$project->office}}</td>
					<td style="width: 5%; text-align: center;">{{$project->price}}</td>
					<th style="width: 30%; text-align: center;">{{$project->title}}</td>
					<th style="width: 25%; text-align: center;">{{$project->p_number}}</th>

				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="text-center pdf-btn">
        <!-- <button type="button" name="download-pdf" class="btn btn-info download-pdf">Download Pdf</button> -->
    </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script type="text/javascript">

    $(".download-pdf").click(function(){

        var data = '';
        $.ajax({
            type: 'GET',
            url: '/report/repo',
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
</body>

</html>