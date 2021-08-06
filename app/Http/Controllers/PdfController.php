<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Project;
use App\Supportive;
use App\Section;
use App\Office;

class PdfController extends Controller
{
    //
    public function index()
    {
        
        $projects = Project::all();
        $supportives=Supportive::all();
        $sections=Section::all();
        $offices=Office::all();
        return view('pdf.index',compact(
            'projects',
        'supportives',
    'sections',
'offices'));
    }

    public function create(Request $request)
    {      
          $supportive=$request->supportive_id;
          info($supportive);

        // session()->flash( $supportive_id);

        // $projects = Project::all();
        $projects = Project::where('supportive_id',$request->supportive_id)->orderBy('created_at','desc')->get();
        $pdf = PDF::loadView('pdf.pdf', compact('projects'),['format' => 'A4-P']);

        // return $projects;
        return $pdf->stream();

    }

    public function  exportPDF(){
        $projects = Project::all();
    
    // $view = 'voyager::reports.print-all';
    $pdf = PDF::loadView('pdf.pdf', compact('projects'),['format' => 'A4-P']);
    return $pdf->download();
    }
    
}
