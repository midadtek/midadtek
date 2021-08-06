<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class StepAction extends AbstractAction
{
    public function getTitle()
    {
        // Action title which display in button based on current status
        return ( $this->data->steps->count())?'تعديل مراحل المشروع':'اضافة مراحل المشروع';
    }
    public function getPolicy()
    {
        if($this->data->status == 3 || $this->data->status == 4) {
            return 'not';
        }else{
            return 'step';
        }                
    }
    public function getIcon()
    {
        // Action icon which display in left of button based on current status
        return'voyager-pie-chart';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'projects';
    }

    public function getDefaultRoute()
    {
        return route('voyager.steps.index', array("project_id"=>$this->data->{$this->data->getKeyName()}));
    }
}