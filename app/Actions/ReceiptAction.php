<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ReceiptAction extends AbstractAction
{
    public function getTitle()
    {
        // Action title which display in button based on current status
        return ($this->data->receipts->count())?'تعديل محاضر الصرف':'اضافة محاضر الصرف';
    }
    public function getPolicy()
    {
        
        if($this->data->status == 3 || $this->data->status == 4) {
            return 'not';
        }else{
            return 'receipt';
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
            'class' => 'btn btn-sm btn-info',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'projects';
    }

    public function getDefaultRoute()
    {
        return route('voyager.receipts.index', array("project_id"=>$this->data->{$this->data->getKeyName()}));
    }
}