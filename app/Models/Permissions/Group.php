<?php

namespace App\Models\Permissions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'sort'
    ];

    public function parent() {
        return $this->belongsTo(Group::class, 'parent_id');
    }
}
