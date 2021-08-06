<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Actions\AbstractAction;

class QuantityAction extends AbstractAction
{
    public function getTitle()
    {
        // Action title which display in button based on current status
        return ($this->data->{'has_quantity'})?'تعديل جدول الكميات':'اضافة جدول الكميات';
    }
    public function getPolicy()
    {
        
        if($this->data->status == 3 || $this->data->status == 4) {
            return 'not';
        }else{
            if (Auth::user()->role->id == '1' || Auth::user()->role->id == '7'){
                return 'quantity';
            }elseif($this->data->quantity_approved == 1){
                return 'not';
            }else{
                return 'quantity';
            }
            
        }
    }
    public function getIcon()
    {
        // Action icon which display in left of button based on current status
        return'voyager-bar-chart';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-warning',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'projects';
    }

    public function getDefaultRoute()
    {
        return route('voyager.quantities.index', array("project_id"=>$this->data->{$this->data->getKeyName()}));
    }
}