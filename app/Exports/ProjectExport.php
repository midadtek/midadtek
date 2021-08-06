<?php

namespace App\Exports;

use App\Project;
use App\Supportive;
use App\Section;
use App\Office;
use App\User;
use App\Manager;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectExport implements FromCollection,WithMapping,WithHeadings
{
   
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     $projects = Project::with('quantities','invoices.itmes')->get();
    //     foreach ($projects as $project) {
    //         $quantities_price = 0;
    //         foreach ($project->quantities as $quantity) {
    //             $quantities_price += $quantity->total_price;                               
    //         }
    //         $project->quantities_price = $quantities_price;
    //     }
        
    //     return $projects;
        // return User::all();->subMonths(1)
    // }
    // public function map($project): array
    // {
    //     return [
    //         $project->title,
    //         $project->quantities_price,
    //         $project->created_at,
    //     ];
    // }


    use Exportable;
    public function __construct($request)
    {
        $this->request = $request;
        // dd($this->supportive_id);
    }
   
   

    public function collection()

    {
        if($this->request->formType === '1'){
            if($this->request->supportive_id){
    
                $supportive = $this->request->supportive_id;
                $supportive_title = Supportive::where('id', $this->request->supportive_id)->get();
                $val = json_decode($supportive_title);
                foreach ($val as $data) {
                    $this->supTitle = $data->title;
                }
                $pr = new Project();
                
                
            if ($this->request->from_date && !$this->request->to_date) {
              
                $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                $to_date=  $pr->getDateNow();   
                 $projects = Project::where('supportive_id', $this->request->supportive_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->orderBy('created_at', 'desc')->get();
                
             } elseif ($this->request->to_date && !$this->request->from_date) {
             
               $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                  $projects = Project::where('supportive_id', $this->request->supportive_id)->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
               
             } elseif ($this->request->from_date && $this->request->to_date) {
                
                $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                  $projects = Project::where('supportive_id', $this->request->supportive_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
             } else {
                 
                //  $from_date= 'البداية';
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=   $pr->getDateNow(); 
                 $projects = Project::where('supportive_id', $this->request->supportive_id)->orderBy('created_at', 'desc')->get();

             }
             
            //  $unique = $projects->unique('section_id'); 
            //  $unique->values()->all();
            //  $project_sum=$projects->sum('price_usd');
            //  $beneficiary_count_sum=$projects->sum('beneficiary_count');
            return $projects;

       
            }
        }
        if($this->request->formType === '2'){
            if($this->request->section_id){
    
                $section= $this->request->section_id;
                $section_title = Section::where('id', $this->request->section_id)->get();
                $val = json_decode($section_title);
                
                $pr = new Project();
                
                
            if ($this->request->from_date && !$this->request->to_date) {
              
                $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                $to_date=  $pr->getDateNow();   
                 $projects = Project::where('section_id', $this->request->section_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->orderBy('created_at', 'desc')->get();
                
             } elseif ($this->request->to_date && !$this->request->from_date) {
             
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('section_id', $this->request->section_id)->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
               
             } elseif ($this->request->from_date && $this->request->to_date) {
                
                 $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('section_id', $this->request->section_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
             } else {
                 
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=   $pr->getDateNow();
                 $projects = Project::where('section_id', $this->request->section_id)->orderBy('created_at', 'desc')->get();
             }
             
            
             return $projects;

        }
                    }
        if($this->request->formType === '3'){
            if($this->request->office_id){
    
                $office= $this->request->office_id;
                $office_title = Office::where('id', $this->request->office_id)->get();
                $val = json_decode($office_title);
                
                $pr = new Project();
                
                
            if ($this->request->from_date && !$this->request->to_date) {
              
                $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                $to_date=  $pr->getDateNow();   
                 $projects = Project::where('office_id', $this->request->office_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->orderBy('created_at', 'desc')->get();
                
             } elseif ($this->request->to_date && !$this->request->from_date) {
             
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('office_id', $this->request->office_id)->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
               
             } elseif ($this->request->from_date && $this->request->to_date) {
                
                 $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('office_id', $this->request->office_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
             } else {
                 
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getDateNow();
                 $projects = Project::where('office_id', $this->request->office_id)->orderBy('created_at', 'desc')->get();
             }
             
            
             $project_sum=$projects->sum('price_usd');
             $beneficiary_count_sum=$projects->sum('beneficiary_count');
             return $projects;

            }
        }
        if($this->request->formType === '4'){
            if($this->request->status){

                $pr = new Project();
                
                
            if ($this->request->from_date && !$this->request->to_date) {
              
                $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                $to_date=  $pr->getDateNow();   
                 $projects = Project::where('status', $this->request->status)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->orderBy('created_at', 'desc')->get();
                
             } elseif ($this->request->to_date && !$this->request->from_date) {
             
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('status', $this->request->status)->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
               
             } elseif ($this->request->from_date && $this->request->to_date) {
                
                 $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('status', $this->request->status)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
             } else {
                 
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date= $pr->getDateNow();  
                 $projects = Project::where('status',$this->request->status)->orderBy('created_at', 'desc')->get();
             }
           
            return $projects;
            }
        }

        if($this->request->formType === '5'){
            if($this->request->user_id){
                $view = 'voyager::reports.print-all-engineer';
                $formType=$this->request->formType;
                $user= $this->request->user_id;
                $user_name = User::where('id', $this->request->user_id)->get();
                $val = json_decode($user_name);
                foreach ($val as $data) {
                    $userName = $data->name;
                }
                $pr = new Project();
                
                
            if ($this->request->from_date && !$this->request->to_date) {
              
                $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                $to_date=  $pr->getDateNow();   
                 $projects = Project::where('engineer_id', $this->request->user_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->orderBy('created_at', 'desc')->get();
             } elseif ($this->request->to_date && !$this->request->from_date) {
             
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('engineer_id', $this->request->user_id)->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
             } elseif ($this->request->from_date && $this->request->to_date) {
                
                 $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('engineer_id', $this->request->user_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
                } else {
                 
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getDateNow();
                 $projects = Project::where('engineer_id', $this->request->user_id)->orderBy('created_at', 'desc')->get();
             }
             
            
             $project_sum=$projects->sum('price_usd');
             return $projects;

            }
        }
        if($this->request->formType === '6'){
            if($this->request->manager_id){
                $view = 'voyager::reports.print-all-engineer';
                $formType=$this->request->formType;
                $manager= $this->request->manager_id;
                $manager_Name = Manager::where('id', $this->request->manager_id)->get();
                $val = json_decode($manager_Name);
                foreach ($val as $data) {
                    $managerName = $data->name;
                }
                $pr = new Project();
                
                
            if ($this->request->from_date && !$this->request->to_date) {
              
                $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                $to_date=  $pr->getDateNow();   
                 $projects = Project::where('manager_id', $this->request->manager_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->orderBy('created_at', 'desc')->get();
             } elseif ($this->request->to_date && !$this->request->from_date) {
             
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('manager_id', $this->request->manager_id)->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
             } elseif ($this->request->from_date && $this->request->to_date) {
                
                 $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('manager_id', $this->request->manager_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
                } else {
                 
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getDateNow();
                 $projects = Project::where('manager_id', $this->request->manager_id)->orderBy('created_at', 'desc')->get();
             }
             
            
             $project_sum=$projects->sum('price_usd');
             return $projects;

            }
        }
        if($this->request->formType === '7'){
            if($this->request->country_id){
                $view = 'voyager::reports.print-all-engineer';
                $formType=$this->request->formType;
                
                $pr = new Project();
                $countryName=$pr->getArabCountry($this->request->country_id);
                
                
            if ($this->request->from_date && !$this->request->to_date) {
              
                $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                $to_date=  $pr->getDateNow();   
                 $projects = Project::where('country', $this->request->country_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->orderBy('created_at', 'desc')->get();
             } elseif ($this->request->to_date && !$this->request->from_date) {
             
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('country', $this->request->country_id)->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
             } elseif ($this->request->from_date && $this->request->to_date) {
                
                 $from_date= $pr->getCreatedAtAttribute($this->request->from_date);
                 $to_date=  $pr->getCreatedAtAttribute($this->request->to_date);  
                 $projects = Project::where('country', $this->request->country_id)->where('created_at', '>=', $pr->getCreatedAtAttribute($this->request->from_date))->where('created_at', '<=', $pr->getCreatedAtAttribute($this->request->to_date))->orderBy('created_at', 'desc')->get();
                } else {
                 
                $from_date= $pr->getCreatedAtAttribute(Project::min('created_at'));
                 $to_date=  $pr->getDateNow();
                 $projects = Project::where('country', $this->request->country_id)->orderBy('created_at', 'desc')->get();
             }
             
            
             $project_sum=$projects->sum('price_usd');
            return $projects;
            }
        }


    }
    
       public function map($project): array
    {
        if($this->request->formType === '1'){
            return [
                $project->beneficiary_count ? $project->getArabBeneficiaryType($project->beneficiary_type): '------------',
                $project->beneficiary_count ? $project->beneficiary_count:'-------',
                $project->office_id ?$project->office->title : '-----',
                 $project->getStatusDisplayAttribute(),
                 $project->price ? $project->getCurrency($project->currency):'------',
    
                 $project->price ? $project->price:'--------',
                                  $project->title,
                 $project->p_number,
                 $project->section_id ?  $project->section->title : '-----------',
                 $project->supportive_id ? $project->supportive->title:'-----------',
                ];
        }
        if($this->request->formType === '2'){
            return [
                $project->office_id ?$project->office->title : '-----',
                                 $project->supportive_id ? $project->supportive->title:'-----------',
                 $project->price ? $project->getCurrency($project->currency):'------',
                 $project->price ? $project->price:'--------',
                                  $project->title,
                 $project->p_number,
                 $project->section_id ?  $project->section->title : '-----------',
                ];

        }
        if($this->request->formType === '3'){
            return [
                $project->beneficiary_count ? $project->getArabBeneficiaryType($project->beneficiary_type): '------------',
                $project->beneficiary_count ? $project->beneficiary_count:'-------',
            $project->supportive_id ? $project->supportive->title:'-----------',
            $project->price ? $project->getCurrency($project->currency):'------',
            $project->price ? $project->price:'--------',
            $project->title,
            $project->p_number,
            $project->section_id ?  $project->section->title : '-----------',
            $project->office_id ?$project->office->title : '-----',            ];
        }

        if($this->request->formType === '4'){
            if($this->request->status === '1'){
                return [
              
                $project->supportive_id ? $project->supportive->title:'-----------',
                $project->price ? $project->getCurrency($project->currency):'------',
                $project->price ? $project->price:'--------',
             
                $project->start_date ? $project->start_date : '------------',
                $project->section_id ?  $project->section->title : '-----------',
                $project->office_id ?$project->office->title : '-----',       
                $project->title,
                $project->p_number,     ];
            }
            }
            if($this->request->status === '2'){
                return [
              
                    $project->supportive_id ? $project->supportive->title:'-----------',
                    $project->price ? $project->getCurrency($project->currency):'------',
                    $project->price ? $project->price:'--------',
                    
                    $project->start_date ? $project->getFinishedAtDateDependOnDuration($project->start_date,$project->duration_unit,$project->duration) : '---------',
                    $project->section_id ?  $project->section->title : '-----------',
                    $project->office_id ?$project->office->title : '-----',   
                    $project->title,
                    $project->p_number,         ];
            }
            if($this->request->status === '5'){
                return [

                $project->supportive_id ? $project->supportive->title:'-----------',
                    $project->price ? $project->getCurrency($project->currency):'------',
                    $project->price ? $project->price:'--------',
                  
                   
                    $project->duration ? $project->getArabUnits($project->duration_unit): '---------',
                    $project->duration ? $project->duration : '----------',
                    $project->start_date ? $project->getTheLateDays($project->getFinishedAtDateDependOnDuration($project->start_date,$project->duration_unit,$project->duration)) : '---------',
                    $project->section_id ?  $project->section->title : '-----------',
                    $project->office_id ?$project->office->title : '-----',    
                    $project->title,
                    $project->p_number,      
                  ];
            }


            if($this->request->formType === '5' || $this->request->formType === '6' || $this->request->formType === '7'){
                return [
         
                    $project->status ?  $project->getStatusDisplayAttribute():'------',
                    $project->currency ? $project->getCurrency($project->currency):'------',
        
                     $project->price ? $project->price:'--------',
                     $project->title ?   $project->title:'--------',
                     $project->p_number ?   $project->p_number:'--------',
                     $project->section_id ?  $project->section->title : '-----------',
                    ];
            }
           
        }

    
    public function headings():array
    {
     
        if($this->request->formType === '1'){
            return ["نوع المستفيد"," عدد المستفيدين", "جهة التنفيذ","حالة المشروع ","العملة","قيمة المشروع","اسم المشروع","رقم المشروع","القطاع","الجهة الداعمة"];
        }
        if($this->request->formType === '2'){
            return ["جهات التنفيذ","الجهة الداعمة","العملة","السعر","اسم المشروع","رقم المشروع","القطاع"];
        }
        if($this->request->formType === '3'){
            return ["نوع المستفيد","عدد المستفيدين","الجهة الداعمة","العملة","قيمة المشروع","اسم المشروع","رقم المشروع","القطاع","مكتب التنفيذ"];

        }

        if($this->request->formType === '4'){
            if($this->request->status === '1'){
                return ["الجهة الداعمة","العملة","قيمة المشروع","تاريخ البدء المتوقع","القطاع","جهات التنفيذ","اسم المشروع","رقم المشروع"];

            }
            if($this->request->status === '2'){
                return ["الجهة الداعمة","العملة","قيمة المشروع","تاريخ النهاية المتوقع","القطاع","جهات التنفيذ","اسم المشروع","رقم المشروع"];

            }
            if($this->request->status === '5'){
                return ["الجهة الداعمة","العملة","قيمة المشروع","واحدة التنفيذ"," مدة التنفيذ","  عدد أيام التأخير","القطاع","جهات التنفيذ","اسم المشروع","رقم المشروع"];

            }

        }
        if($this->request->formType === '5' || $this->request->formType === '6' || $this->request->formType === '7'){
            return [ "حالة المشروع ","العملة","قيمة المشروع","اسم المشروع","رقم المشروع","القطاع"];

        }
    }
    
    }
