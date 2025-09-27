<?php
namespace Hipster\Discount\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDiscount extends Model
{
    protected $fillable = ['user_id','discount_id','used_count'];

    public function discount(): BelongsTo {
        return $this->belongsTo(Discount::class);
    }

    public function eligible(): bool {
        if (!$this->discount->isValid()) return false;
        if ($this->discount->usage_limit !== null && $this->used_count >= $this->discount->usage_limit) return false;
        return true;
    }
}
