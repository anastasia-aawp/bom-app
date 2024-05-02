<?php

namespace App\Http\Controllers;

use App\Models\MstMaterial;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class MstMaterialController extends DefaultController
{
    protected $modelClass = MstMaterial::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Master Material';
        $this->generalUri = 'mst-material';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Unit', 'column' => 'uom', 'order' => true],
                    ['name' => 'Price', 'column' => 'price', 'order' => true],
                    ['name' => 'Description', 'column' => 'description', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Uom', 'column' => 'uom'],
                    ['name' => 'Price', 'column' => 'price'],
                    ['name' => 'Description', 'column' => 'description'], 
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
                        'label' => 'Uom',
                        'name' =>  'uom',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('uom', $id),
                        'value' => (isset($edit)) ? $edit->uom : ''
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
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'uom' => 'required|string',
                    'price' => 'required|string',
                    'description' => 'required|string',
        ];

        return $rules;
    }

}
