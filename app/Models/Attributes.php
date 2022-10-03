<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'attributes';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $appends = ['type_name', 'status_name', 'attributesvalue'];

    // protected $app = ['status'];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function typeData($id = null) {
        $data = [
            1 => "Checkbox",
            2 => "Dropdown",
            3 => "Multiple Images",
            4 => "Textbox",
            5 => "Textarea",
            6 => "Image",
            7 => "Date"
        ];
        return ($id) ? $data[$id] : $data;
    }

    public static function typeStatus($id = null) {
        $status = [
            1 => "Active",
            2 => "Deactive",
        ];
        return ($id) ? $status[$id] : $status;
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function attributesdata() {
        return $this->hasMany(AttributesValue::class, 'attributes_id');
    }

    

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getTypeNameAttribute() {
        return ($this->category_type) ? $this->typeData($this->category_type) : '-';
    }

    public function getStatusNameAttribute() {
        return ($this->status) ? $this->typeStatus($this->status) : '-';
    }

    public function getAttributesvalueAttribute() {
        return ($this->attributesdata) ? $this->attributesdata : [];
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
