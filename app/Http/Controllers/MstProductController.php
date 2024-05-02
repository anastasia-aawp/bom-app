<?php

namespace App\Http\Controllers;


use App\Models\MstProduct;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use App\Models\MstMaterial;

use Exception;

use Idev\EasyAdmin\app\Helpers\Validation;
use Idev\EasyAdmin\app\Imports\DefaultImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Throwable;

class MstProductController extends DefaultController
{
    protected $modelClass = MstProduct::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Master Product';
        $this->generalUri = 'mst-product';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Price', 'column' => 'price', 'order' => true],
                    ['name' => 'Modal price', 'column' => 'modal_price', 'order' => true],
                    ['name' => 'Description', 'column' => 'description', 'order' => true],
                    ['name' => 'Uom', 'column' => 'uom', 'order' => true],
                    ['name' => 'Materials', 'column' => 'materials', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Price', 'column' => 'price'],
                    ['name' => 'Modal price', 'column' => 'modal_price'],
                    ['name' => 'Description', 'column' => 'description'],
                    ['name' => 'Uom', 'column' => 'uom'],
                    ['name' => 'Materials', 'column' => 'materials'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $fields = [
                    [
                        'type' => 'text',
                        'label' => 'Name',
                        'name' =>  'name',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->name : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Price',
                        'name' =>  'price',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('price', $id),
                        'value' => (isset($edit)) ? $edit->price : ''
                    ],

                    [
                        'type' => 'text',
                        'label' => 'Description',
                        'name' =>  'description',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('description', $id),
                        'value' => (isset($edit)) ? $edit->description : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Uom',
                        'name' =>  'uom',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('uom', $id),
                        'value' => (isset($edit)) ? $edit->uom : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Materials',
                        'name' =>  'materials',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('materials', $id),
                        'value' => (isset($edit)) ? $edit->materials : ''
                    ],
                    [
                        'type' => 'repeatable',
                        'label' => 'Materials',
                        'name' => 'materials',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('materials', $id),
                        'value' => (isset($edit)) ? $edit->materials : '',
                        'enable_action' => true,
                        'html_fields' => [
                        [
                        'type' => 'select',
                        'label' => 'Material',
                        'name' => 'material_id',
                        'class' => 'col-md-7 my-2',
                        'value' => '',
                        'options' => MstMaterial::get(['id', 'name'])
                        ->map(function ($item) {
                        return [
                        'value' => $item->id,
                        'text' => $item->name
                        ];
                        })
                        ->toArray()
                        ],
                        [
                        'type' => 'number',
                        'label' => 'Qty',
                        'name' => 'qty',
                        'class' => 'col-md-3 my-2',
                        ],
                        ]
                       ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'price' => 'required|string',
                    'modal_price' => 'required|string',
                    'description' => 'required|string',
                    'uom' => 'required|string',
                    'materials' => 'required|string',
        ];
        

        return $rules;
        

    }

    protected function store(Request $request)
    {

        $rules = []; //$this->rules();
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        $uom = $request->uom;

        $materialIds = $request->material_id;
        $qtys = $request->qty;

        $arrQty = [];
        foreach ($materialIds as $key => $mi) {
            $arrQty[$mi] = $qtys[$key];
        }

        $mstMaterials = MstMaterial::whereIn('id', $materialIds)->get();
        $arrMaterials = [];
        $modalPrice = 0;
        foreach ($mstMaterials as $key => $mm) {
            $arrMaterials[] = [
                'material_id' => $mm->id,
                'name' => $mm->name,
                'price' => $mm->price,
                'qty' => $arrQty[$mm->id]
            ];

            $modalPrice += $mm->price * $arrQty[$mm->id];
        }
        $materials = json_encode($arrMaterials);

        //if (condition) {
            // respon()->json([])
       //}

        DB::beginTransaction();

        try {

            $insert = new $this->modelClass();
            $insert ->name = $name;
            $insert ->price = $price;
            $insert ->modal_price = $modalPrice;
            $insert ->description = $description;
            $insert ->uom = $uom;
            $insert ->materials = $materials;

            $insert->save();

            $this->afterMainInsert($insert, $request);

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Created Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }



}
