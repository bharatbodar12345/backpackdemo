<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributesRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Attributes;
use App\Models\AttributesValue;
use Backpack\CRUD\app\Library\Widget;


/**
 * Class AttributesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AttributesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Gaspertrix\LaravelBackpackDropzoneField\App\Http\Controllers\Operations\MediaOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }



    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Attributes::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attributes');
        CRUD::setEntityNameStrings('attributes', 'attributes');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('category_id');
        CRUD::column('name');
        CRUD::column('type_name')->label('Category Type');
        CRUD::column('status_name')->label('Status');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AttributesRequest::class);

        CRUD::field('id')->type('hidden');
        CRUD::field('category_id');
        CRUD::addField([
            'name'    => 'category_type',
            'type'    => 'select2_from_array',
            'label'   => 'Type',
            'wrapper' => ['class' => 'form-group col-md-4 select-test','id' => 'select'],
            'options' => Attributes::typeData(),
        ]);
        CRUD::addField([
            'name'    => 'name',
            'type'    => 'text',
            'label'   => 'Attribute Name',
        ]);
        CRUD::addField(
            [
                'name' => 'status',
                'label' => 'Attributes Status',
                'type' => 'radio',
                'options' => [
                    0 => 'Deactive',
                    1 => 'Active',
                ],
                'inline' => true,
            ],
        );
        CRUD::addfield([
            'name'  => 'attributes',
            'label' => 'Attributes Value',
            'type'  => 'repeatable',
            'wrapper' => ['class' => 'form-group col-md-4 attributes d-none'],
            'fields' => [
                [
                    'name'    => 'attributes_value',
                    'type'    => 'text',
                    'label'   => 'Attribute Value',
                ],
                [
                    'name' => 'attributes_status',
                    'label' => 'Attributes Status',
                    'type' => 'radio',
                    'options' => [
                        0 => 'Deactive',
                        1 => 'Active',
                    ],
                    'inline' => true,
                ],
            ],
            'new_item_label'  => 'Add Attribute',
        ]);
        Widget::add([
            'type'    => 'script',
            'content' => 'js/user-js/category-update.js'
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        // $this->setupCreateOperation();

        CRUD::setValidation(AttributesRequest::class);

        CRUD::field('id')->type('hidden');
        CRUD::field('category_id');
        CRUD::addField([
            'name'    => 'category_type',
            'type'    => 'select2_from_array',
            'label'   => 'Category Type',
            'wrapper' => ['class' => 'form-group col-md-4 select-test','id' => 'select'],
            'options' => Attributes::typeData(),
        ]);
        CRUD::addField([
            'name'    => 'name',
            'type'    => 'text',
            'label'   => 'Attribute Name',
        ]);
        CRUD::addField(
            [
                'name' => 'status',
                'label' => 'Attributes Status',
                'type' => 'radio',
                'options' => [
                    0 => 'Deactive',
                    1 => 'Active',
                ],
                'inline' => true,
            ],
        );
        CRUD::addfield([
            'name'  => 'attributesvalue',
            'label' => 'Attributes Value',
            'type'  => 'repeatable',
            'entity'    => 'attributesdata',
            'wrapper' => ['class' => 'form-group col-md-4 attributes'],
            'fields' => [
                [
                    'name'    => 'id',
                    'type'    => 'hidden',
                ],
                [
                    'name'    => 'attribute_name',
                    'type'    => 'text',
                    'label'   => 'Attribute Value',
                ],
                [
                    'name' => 'status',
                    'label' => 'Attributes Status',
                    'type' => 'radio',
                    'options' => [
                        0 => 'Deactive',
                        1 => 'Active',
                    ],
                    'inline' => true,
                ],
            ],
            'new_item_label'  => 'Add Attribute',
        ]);
        Widget::add([
            'type'    => 'script',
            'content' => 'js/user-js/category-update.js'
        ]);

    }
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column('name');
        CRUD::addColumn('type_name');
        CRUD::addColumn('status_name');

        CRUD::addColumn([
            'name'      => 'attribute_value',
            'label'     => 'Attribute Value',
            'type'     => 'closure',
            'function' => function($entry) {
                $data = $entry->attributesdata;
                $arr=[];
                foreach ($data as $key) {
                    $arr[]= $key->id;
                }
                $entry = AttributesValue::whereIn('id',$arr)->get();
                return view('vendor.return.attribute_valuedata', ['entry' => $entry])->render();
            }
        ]);
    }
    public function store(AttributesRequest $request)
    {
        $response = $this->traitStore();
        $attributes_id = $this->crud->entry->id;
        $json = json_decode($request['attributes']);
        if(count($json) && $json[0]->attributes_value != null ){
            foreach(json_decode($request['attributes']) as $value) {
                $items_sub = new AttributesValue();
                $items_sub->attributes_id = $attributes_id;
                $items_sub->attribute_name = $value->attributes_value;
                if($value->attributes_status != null){
                $items_sub->status = $value->attributes_status;
                }
                else{
                    $items_sub->status = "0";
                }
                $items_sub->save();
            }
        }

        return $response;
    }
    public function update(AttributesRequest $request)
    {
        $data = Attributes::find($request->id);
        $data->category_id   = $request->category_id;
        $data->category_type    = $request->category_type;
        $data->name    = $request->name;
        $data->status = $request->status;
        $data->save();
        $attributes_id = $data->id;
        $attrIds = [];
        $json = json_decode($request['attributesvalue']);
        if(count($json) && $json[0]->attribute_name != null ){
            foreach(json_decode($request['attributesvalue']) as $value) {
                if ($value->id != null) {
                    $item =  AttributesValue::find($value->id);
                    $item->attributes_id = $attributes_id;
                    $item->attribute_name = $value->attribute_name;
                    $item->status = $value->status;
                    $item->save();
                } else {
                    $item =  AttributesValue::find($value->id);
                    $item->attributes_id = $attributes_id;
                    $item->attribute_name = $value->attribute_name;
                    $item->status = $value->status;
                    $item->save();
                }
                $attrIds[] = $item->id;
            }
        }
        $delete = AttributesValue::whereNotIn('id',$attrIds)->where('attributes_id',$attributes_id)->delete();
        return redirect('/admin/attributes');
    }
    public function destroy($id)
    {
        AttributesValue::where('attributes_id',$id)->delete();
        return $this->crud->delete($id);
    }

}
