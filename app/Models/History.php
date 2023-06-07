<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = "histories";
    protected $fillable = ['title', 'type', 'date_start', 'date_end', 'info1', 'info2', 'info3', 'description'];
}
