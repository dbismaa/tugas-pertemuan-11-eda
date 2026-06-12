<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformaMahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [];
}