<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 PDF File Download using JQuery Ajax Request Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">
    h2{
        text-align: center;
        font-size:22px;
        margin-bottom:50px;
    }
    body{
        background:#f2f2f2;
    }
    .section{
        margin-top:30px;
        padding:50px;
        background:#fff;
    }
    .pdf-btn{
        margin-top:30px;
    }
</style>  
<body>
    <table>
        <thead>
            <tr>
                <th>
                title
            </th>
            <th>
                doner_name
            </th>
            <th>
                city
            </th>
            <th>
            supportive_id
            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr>
                <td>
                    {{
                        $project->title
                    }}
                </td>
                <td>
                {{
                        $project->doner_name
                    }}
                </td>
                <td>
                {{
                        $project->city
                    }}
                </td>
                <td>
                {{ $project->supportive_id}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
	<!-- <div class="container">
        <div class="col-md-8 section offset-md-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2>Laravel 8 PDF File Download using JQuery Ajax Request Example - NiceSnippets.com</h2>
                </div>
                <div class="panel-body">
                    <div class="main-div">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        <br>
                        <br>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</body>
</html>