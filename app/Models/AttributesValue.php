<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributesValue extends Model
{
    use HasFactory, CrudTrait;

    protected $table = 'attributes_value';

    public function attributes() {
        return $this->belongsToMany(Attributes::class, 'id');
    }
}
