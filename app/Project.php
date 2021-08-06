<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use TCG\Voyager\Traits\Spatial;
class Project extends Model
{
    use Spatial;
    protected $spatial = ['location'];
    protected $guarded = []; 

    public function office(){
        return $this->belongsTo(Office::class);

    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function supportive()
    {
        return $this->belongsTo(Supportive::class);
    }

    public function scopeOtherprojects($query){
        $project_id = (Cookie::get('project_id')) ? Cookie::get('project_id') : 1;
        return $query->whereIn('status', [2,5])->where('id','!=',$project_id);
    }
    public function scopeEngineers($query)
    {
        
        if(Auth::user()->role_id == 6 || Auth::user()->role_id == 8){            
            return $query->where('engineer_id',Auth::user()->id);
        }
        else{ 
            return $query;
        }

        
            
    }
    public function getHasQuantityAttribute()
    {
        if ($this->quantities->count()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all of the quantities for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quantities()
    {
        return $this->hasMany(Quantity::class);
    }
    /**
     * Get all of the invoices for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    /**
     * Get all of the receipts for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
        /**
     * Get all of the steps for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    /**
     * Get all of the receiptItems for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function receiptItems()
    {
        return $this->hasManyThrough(ReceiptItem::class, Receipt::class);
    }
    /**
     * Get all of the invoiceItems for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function invoiceItems()
    {
        return $this->hasManyThrough(InvoiceItem::class, Invoice::class);
    }

    /**
     * Get all of the transfers for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
    /**
     * Get all of the transferItems for the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function transferItems()
    {
        return $this->hasManyThrough(TransferItem::class, Transfer::class);
    }

    public function getStatusDisplayAttribute()
    {
        switch ($this->status) {
            case '1':
               { return 'لم يبدأ بعد';
                break;
            }
            case '2':
                { return 'جاري العمل فيه';
                 break;
             }
             case '3':
                { return 'تم الانتهاء من التنفيذ';
                 break;
             }
             case '4':
                { return 'ملغي';
                 break;
             }
             case '5':
                { return ' متأخر عن الوقت المحدد';
                 break;
             }
            default:
                # code...
                break;
        }
    }
    public function getFullTitleAttribute(){
        return $this->p_number . ' - '. $this->title;
    }
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case '1':
               { return '#ffffff';
                break;
            }
            case '2':
                { return '#cbf3f0';
                 break;
             }
             case '3':
                { return '#d4e09b';
                 break;
             }
             case '4':
                { return '#ffbf69';
                 break;
             }
             case '5':
                { return '#ff99ac';
                 break;
             }
            default:
                # code...
                break;
        }
    }
    public static function getUnit($index): string {
        switch ($index) {
            case '1':
               { return 'day';
                break;
            }
            case '2':
                { return 'month';
                 break;
             }
             case '3':
                { return 'year';
                 break;
             }
            default:
                {
                    return 'day';
                    break;
                }
        }
      }
      public static function getArabUnits($index): string {
        switch ($index) {
            case '1':
               { return 'يوم';
                break;
            }
            case '2':
                { return 'اشهر';
                 break;
             }
             case '3':
                { return 'سنة';
                 break;
             }
            default:
                {
                    return 'يوم';
                    break;
                }
        }
      }
      public static function getArabBeneficiaryType($index): string {
        switch ($index) {
            case '1':
               { return 'فرد';
                break;
            }
            case '2':
                { return 'اسرة';
                 break;
             }
        }
      }

      public static function getArabCountry($index): string {
        switch ($index) {
            case '1':
               { return 'سوريا';
                break;
            }
            case '2':
                { return 'تركيا';
                 break;
             }
        }
      }
     
      
      public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    public function getFinishedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    public function getCanceledAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    public function getDateNow()
    {
       
        $date = Carbon::now();
        return $date->toDateString();
    }

    public function getFinishedAtDateDependOnDuration($startDate,$durationUnit,$duration){
        $date = Carbon::parse($startDate);
        switch ($durationUnit) {
            case '1':
               { 
                   return  $date->addDays($duration); 
                break;
            }
            case '2':
                { return $date->addMonths($duration);
                 break;
             }
             case '3':
                { return $date->addYears($duration);
                 break;
             }
        }
    }
    public function getTheLateDays($finishedAtDate){
        $to = Carbon::now();
        $diff_in_days = $to->diffInDays($finishedAtDate);
       return $diff_in_days;
    }
    public function getCurrency($currency){

        switch ($currency) {
            case 1:
               { return 'دولار';
                break;
            }
            case 2:
                { return 'ليرة تركية';
                 break;
             }
             case 3:
                { return 'يورو';
                 break;
             }
             case 4:
                {
                    return 'دينار كويتي';
                    break;
                }
        }
      
    }
}
