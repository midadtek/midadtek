<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class InvoiceAction extends AbstractAction
{
    public function getTitle()
    {
        // Action title which display in button based on current status
        return ( $this->data->invoices->count())?'تعديل محاضر الاستلام':'اضافة محاضر الاستلام';
    }
    public function getPolicy()
    {
        if($this->data->status == 3 || $this->data->status == 4) {
            return 'not';
        }else{
            return 'invoice';
        }                
    }
    public function getIcon()
    {
        // Action icon which display in left of button based on current status
        return'voyager-receipt';
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
        return route('voyager.invoices.index', array("project_id"=>$this->data->{$this->data->getKeyName()}));
    }
}