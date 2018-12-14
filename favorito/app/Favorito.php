<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $table = "link";
    protected $primaryKey   = 'cd_link';
    protected $fillable = ['no_link','link','vl_link','bo_ativo','cd_usuario','cd_categoria']; 
}
