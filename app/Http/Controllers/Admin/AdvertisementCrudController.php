<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdvertisementRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Attributes;
use App\Models\Advertisement;
use App\Models\AdvertisementValue;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use App\Models\AttributesValue;


/**
 * Class AdvertisementCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdvertisementCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Advertisement::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/advertisement');
        CRUD::setEntityNameStrings('advertisement', 'advertisements');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::field('category_id');
        $this->crud->addColumns(['category_id']);

        // $this->crud->addColumn('Name', [
        //     'label' => 'Name',
        //     'type' => 'relationship',
        //     'name' => 'advertisedata', // the db column for the foreign key
        //     'entity' => 'advertisedata', // the method that defines the relationship in your Model
        //     'attribute' => 'name', // foreign key attribute that is shown to user
        //     'model' => 'App\Models\Advertisement' // foreign key model
        // ]);

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

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::addColumn('category_id');
        CRUD::addColumn([
            'name'      => 'advertise_name',
            'label'     => 'Advertisement Name',
            'type'     => 'closure',
            'function' => function($entry) {
                $entry = AdvertisementValue::whereIn('id',Advertisement::where('category_id',$entry->category_id)->pluck('id')->toArray())->get();
                return view('vendor.return.advertisement_namedata
                ', ['entry' => $entry])->render();
            }
        ]);
        CRUD::addColumn([
            'name'      => 'advertisement',
            'label'     => 'Advertisement Value',
            'type'     => 'closure',
            'function' => function($entry) {
                $entry = AdvertisementValue::whereIn('id',Advertisement::where('category_id',$entry->category_id)->pluck('id')->toArray())->get();
                return view('vendor.return.advertisement_valuedata', ['entry' => $entry])->render();
            }
        ]);
    }
    protected function setupCreateOperation()
    {

        CRUD::setValidation(AdvertisementRequest::class);

        CRUD::field('id')->type('hidden');
        CRUD::field('category_id')->wrapper(['class' => 'form-group col-md-4 select_category','id' => 'select_category', 'data-action' => route('getadvertisement')]);
        CRUD::field('dropzone')->type('hidden')->wrapper(['class' => 'ajaxUploadImages', 'id' => 'ajaxUploadImages', 'data-action' => route('ajaxUploadImages'), 'data-removeaction' => route('ajaxremoveImages')]);
        // CRUD::field('ajaxremoveImages')->type('hidden')->wrapper(['class' => 'ajaxremoveImages', 'id' => 'ajaxremoveImages', 'data-action' => route('ajaxremoveImages')]);
        CRUD::addfield(
            [
                'name'     => 'my_custom_html',
                'label'    => 'Custom HTML',
                'type'     => 'custom_html',
                'value'    => '<div class ="custom_html"></div>',
                'wrapper' => ['class' => 'form-group col-md-12 d-none htmlview','id' => 'htmlview']
            ],
        );
        Widget::add([
            'type'    => 'script',
            'content' => 'js/user-js/advertisement.js'
        ]);
        Widget::add()->type('script')
            ->content('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js');
        Widget::add()->type('script')
            ->content('https://rawgit.com/enyo/dropzone/master/dist/dropzone.js');
        Widget::add()->type('style')
            ->content('https://rawgit.com/enyo/dropzone/master/dist/dropzone.css');
        Widget::add([
            'type'    => 'style',
            'content' => 'css/image-new.css'
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
        CRUD::setValidation(AdvertisementRequest::class);
        CRUD::field('id')->type('hidden')->wrapper(['class' => 'hidden_id']);
        CRUD::field('action')->type('hidden')->wrapper(['class' => 'action', 'id' => 'action', 'data-action' => route('geteditadvertisement')]);
        CRUD::field('dropzone')->type('hidden')->wrapper(['class' => 'ajaxUploadImages', 'id' => 'ajaxUploadImages', 'data-action' => route('ajaxUploadImages'), 'data-removeaction' => route('ajaxremoveImages')]);
        CRUD::field('category_id')->wrapper(['class' => 'form-group col-md-4 select_category','id' => 'select_category', 'data-action' => route('getadvertisement')]);
        // CRUD::field('ajaxremoveImages')->type('hidden')->wrapper(['class' => 'ajaxremoveImages', 'id' => 'ajaxremoveImages', 'data-action' => route('ajaxremoveImages')]);


        CRUD::addfield(
            [
                'name'     => 'my_custom_html',
                'label'    => 'Custom HTML',
                'type'     => 'custom_html',
                'value'    => '<div class ="custom_html"></div>',
                'wrapper' => ['class' => 'form-group col-md-12 htmlview','id' => 'htmlview']
            ],
        );

        Widget::add([
            'type'    => 'script',
            'content' => 'js/user-js/advertisement.js'
        ]);
        Widget::add()->type('script')
            ->content('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js');
        Widget::add()->type('script')
            ->content('https://rawgit.com/enyo/dropzone/master/dist/dropzone.js');
        Widget::add()->type('style')
            ->content('https://rawgit.com/enyo/dropzone/master/dist/dropzone.css');
        // Widget::add([
        //     'type'    => 'style',
        //     'content' => 'js/user-js/image-new.css'
        // ]);
    }

    public function getadvertisement(Request $request)
    {
        // dd('1');
        $attributeData = Attributes::where('category_id', $request->selected)->get();
        $crudFields = [];
        foreach($attributeData as $key => $value) {

            switch ($value->category_type) {

                case 1:
                    $options = [];
                    foreach($value->attributesdata as $key => $val) {
                        $options[$val->attribute_name] = $val->attribute_name;
                    }
                    $crudFields[]  =[
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'checklist-new',
                        'wrapper'   => ['class' => 'form-group col-md-4 checklist'],
                        'options'   => $options,
                    ];
                    $crudFields[]  =[
                        'name'      => $value->name.'_id',
                        'type'      => 'hidden',
                        'value'     => $value->id
                    ];
                    break;
                case 2:
                    $options = [];
                    foreach($value->attributesdata as $key => $val) {
                        $options[$val->attribute_name] = $val->attribute_name;
                    }
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'select2_from_array',
                        'options'   =>  $options,
                    ];
                    $crudFields[]  = [
                        'name'      => $value->name.'_id',
                        'type'      => 'hidden',
                        'value'     => $value->id
                    ];
                    break;
                case 3:
                    $crudFields[] = [
                        'name'          => $value->name,
                        'label'         => ucFirst($value->name),
                        'type'          => 'dropzone',
                        'upload_route'  => route('ajaxUploadImages'),
                        'reorder_route' => 'reorder_images',
                        'delete_route'  => 'delete_image',
                        'disk'          => 'uploads/images/',
                        'mimes'         => 'image/*',
                        'filesize'      => 5,
                    ];
                    $crudFields[]  = [
                        'name'      => $value->name.'_id',
                        'type'      => 'hidden',
                        'value'     => $value->id
                    ];
                    break;
                case 4:
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'text',
                    ];
                    $crudFields[]  = [
                        'name'      => $value->name.'_id',
                        'type'      => 'hidden',
                        'value'     => $value->id
                    ];
                    break;
                case 5:
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'textarea',
                    ];
                    $crudFields[]  = [
                        'name'      => $value->name.'_id',
                        'type'      => 'hidden',
                        'value'     => $value->id
                    ];
                    break;
                case 6:
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'custom-image',
                    ];
                    $crudFields[]  = [
                        'name'      => $value->name.'_id',
                        'type'      => 'hidden',
                        'value'     => $value->id
                    ];
                    break;
                case 7:
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'date',
                    ];
                    $crudFields[]  = [
                        'name'      => $value->name.'_id',
                        'type'      => 'hidden',
                        'value'     => $value->id
                    ];
                    break;
                default:
            }
        }
        $this->crud->fields = $crudFields;
        $view = \View::make('vendor.backpack.crud.advertisement_form', [ 'fields' => $crudFields, 'action' => 'create' , 'crud' => $this->crud]);
        $view = $view->render();
        $view = html_entity_decode($view);
        return response()->json(array('success' => true, 'view'=>$view));
    }
    public function geteditadvertisement(Request $request)
    {
        // dd('2');
        $attributeData = Attributes::where('category_id', $request->selected)->get();
        $crudFields = [];
        foreach($attributeData as $key => $value) {
            $addsData = AdvertisementValue::where([['advertisement_id',$request->id],['attributes_id', $value->id]])->first();

            $crudFields[]  = [
                'name'      => $value->name.'_id',
                'type'      => 'hidden',
                'value'     => $value->id
            ];

            if(isset($addsData)) {
                $crudFields[]  = [
                    'name'      => $value->name.'_id1',
                    'type'      => 'hidden',
                    'value'     => $addsData->id
                ];
            }

            switch ($value->category_type) {
                case 1:
                    $options = [];
                    foreach($value->attributesdata as $key => $val) {
                        $options[$val->attribute_name] = $val->attribute_name;
                    }

                    $crudFields[]  = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'checklist-new',
                        'wrapper'   => ['class' => 'form-group col-md-4 checklist'],
                        'options'   => $options,
                        'selected'     => (isset($addsData->value)) ? json_decode($addsData->value) : ''
                    ];
                    break;
                case 2:
                    $options = [];
                    foreach($value->attributesdata as $key => $val) {
                        $options[$val->attribute_name] = $val->attribute_name;
                    }

                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'select2_from_array',
                        'options'   =>  $options,
                        'value'     => (isset($addsData)) ? $addsData->value : ''
                    ];

                    break;
                case 3:
                    $quary = AdvertisementValue::where([['advertisement_id',$request->id],['attributes_id', $value->id]])->first();
                    // dd($quary);
                    $images = [];
                    $images_val = [];
                    if(isset($addsData) && isset($addsData->value)){
                        foreach(explode(',',$addsData->value) as $items){
                            $images[] = route('getStoragePath', ['image', $items]);
                            $images_val[] = $items;
                            }
                        }
                    // dd($images_val);
                    $crudFields[] = [
                        'name'          => $value->name,
                        'label'         => ucFirst($value->name),
                        'type'          => 'dropzone',
                        'upload_route'  => route('ajaxUploadImages'),
                        'reorder_route' => 'reorder_images',
                        'delete_route'  => 'delete_image',
                        'disk'          => 'uploads/images/',
                        'mimes'         => 'image/*',
                        'filesize'      => 5,
                        'imager_path'   => $images,
                        'value'         => $images_val
                    ];
                    // dd($crudFields);
                    break;
                case 4:
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'text',
                        'value'     => (isset($addsData)) ? $addsData->value : ''
                    ];
                    break;
                case 5:
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'textarea',
                        'value'     => (isset($addsData)) ? $addsData->value : ''
                    ];
                    break;
                case 6:
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'custom-image',
                        'wrapper'   => ['class' => 'form-group col-md-12 image'],
                        'value'     => (isset($addsData)) ? route('getStoragePath', ['image', $addsData->value]) : ''
                    ];
                    break;
                case 7:
                    $crudFields[] = [
                        'name'      => $value->name,
                        'label'     => ucFirst($value->name),
                        'type'      => 'date',
                        'value'     => (isset($addsData)) ? $addsData->value : ''
                    ];
                    break;
                default:
            }
        }

        $this->crud->fields = $crudFields;
        $view = \View::make('vendor.backpack.crud.advertisement_form', [ 'fields' => $crudFields, 'action' => 'create' , 'crud' => $this->crud]);
        $view = $view->render();
        $view = html_entity_decode($view);
        return response()->json(array('success' => true, 'view'=>$view));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $fiels=array_keys($request->all());
        unset($fiels[0]);
        unset($fiels[1]);
        unset($fiels[2]);
        unset($fiels[3]);
        foreach($fiels as $k=>$f){
            if(substr($f, -3) == '_id' || $f == 'save_action' || $f == 'dropzone' || $f == 'path'){
                unset($fiels[$k]);
            }
        }
        $items = new Advertisement;
        $items ->category_id = $request->category_id;
        $items->save();
        if($items->save()){
            foreach($fiels as $value){
                $attributes_id = $value.'_id';
                $advertisement_value = New AdvertisementValue;
            // if($value == 'Image'){
                if($request->hasFile($value)){
                    $file = $request->file($value);
                    $filename = $file->getClientOriginalName();
                    $file->move(storage_path('/app/public/image'),$filename);
                    // $uniqe_name = uniqid();
                    $advertisement_value->value = $filename;
                    $advertisement_value->advertisement_id = $items->id;
                    $advertisement_value->name = $value;
                    $advertisement_value->attributes_id = $request->$attributes_id;
                    $advertisement_value->save();
                } else {
                    $advertisement_value->advertisement_id = $items->id;
                    $advertisement_value->value = $request->$value;
                    $advertisement_value->name = $value;
                    $advertisement_value->attributes_id = $request->$attributes_id;
                    $advertisement_value->save();
                }
            // }
             }
        }
        return redirect()->back();
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $fiels = array_keys($request->all());
        unset($fiels[0]);
        unset($fiels[1]);
        unset($fiels[2]);
        unset($fiels[4]);
        foreach($fiels as $k => $f){
            if(substr($f, -3) == '_id' || substr($f, -4) == '_id1' || $f == 'save_action' || $f == 'id' || $f == 'dropzone' || $f == 'path'){
                unset($fiels[$k]);
            }
        }
        $items = Advertisement::find($request->id);
        $items->category_id = $request->category_id;
        $items->save();
        $attrIds = [];
        $i = 0;
        if($items->save()){
            foreach($fiels as $value){
                // if($value == 'poto'){
                    if($request->{$value . "_id1"}){
                        if($request->hasFile($value)){
                            $ad_value =  AdvertisementValue::find($request->{$value . "_id1"});
                            $path = storage_path('/app/public/image/').$ad_value->value;
                            if (file_exists($path)) {
                                unlink($path);
                            }
                            $file = $request->file($value);
                            $filename = $file->getClientOriginalName();
                            $file->move(storage_path('/app/public/image'),$filename);
                            $ad_value->value = $filename;
                        } else{
                            $ad_value =  AdvertisementValue::find($request->{$value . "_id1"});
                        }

                    } else {
                        $ad_value = New AdvertisementValue;
                        if($request->hasFile($value)){
                            $file = $request->file($value);
                            $filename = $file->getClientOriginalName();
                            $file->move(storage_path('/app/public/image'),$filename);
                            $ad_value->value = $filename;
                        }
                    }
                // }
                $ad_value->advertisement_id = $request->id;
                $ad_value->attributes_id = $request->{$value . "_id"};
                if(!$request->hasFile($value)){
                $ad_value->value = $request->$value;
                }
                $ad_value->name = $value;
                $ad_value->save();
            }
        // dd($value);
            $attrIds[] = $request->{$value . "_id"};
        }
        // $delete = AdvertisementValue::whereNotIn('id',$attrIds)->where('attributes_id',$request->{$value . "_id"})->delete();
        return redirect()->back();
    }
    public function destroy($id)
    {
        Advertisement::where('id', $id)->delete();
        AdvertisementValue::where('advertisement_id', $id)->delete();
        return $this->crud->delete($id);
    }

    public function ajaxUploadImages(Request $request)
    {
        // $imageName = time().'.'.$request->image->extension();
        if($request->file){
            foreach($request->file as $key => $file){
                $path = storage_path('/app/public/image');
                $imageName = $file->getClientOriginalName();
                $file->move($path,$imageName);
            }
        }
        return $imageName;
    }
    public function ajaxRemoveImages(Request $request)
    {
        if($request->file){
            $path = storage_path('/app/public/image/'). $request->file;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return true;
    }
}
