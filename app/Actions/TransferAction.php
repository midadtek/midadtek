<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class TransferAction extends AbstractAction
{
    public function getTitle()
    {
        // Action title which display in button based on current status
        return ($this->data->transfers->count())?'تعديل محاضر النقل':'اضافة محاضر النقل';
    }
    public function getPolicy()
    {
        
        if($this->data->status == 3 || $this->data->status == 4) {
            return 'not';
        }else{
            return 'transfer';
        }
    }
    public function getIcon()
    {
        // Action icon which display in left of button based on current status
        return'voyager-resize-full';
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
        return route('voyager.transfers.index', array("project_id"=>$this->data->{$this->data->getKeyName()}));
    }
}