<?php
namespace Hipster\Discount\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountAudit extends Model
{
    protected $fillable = ['user_id','discount_id','applied_amount'];
}
