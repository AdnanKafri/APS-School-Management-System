<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report_card_details extends Model
{

    protected $table='report_card_details';

    protected $fillable=['id','year_id','class_id','report_card_status','manager_name','actual_attendance','report_card_date'];

}
