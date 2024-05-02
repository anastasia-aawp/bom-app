<?php

namespace App\Http\Controllers;

use App\Models\TransProduct;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TransProductController extends DefaultController
{
    protected $modelClass = TransProduct::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Trans Product';
        $this->generalUri = 'trans-product';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Product id', 'column' => 'product_id', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Price', 'column' => 'price', 'order' => true],
                    ['name' => 'Total price', 'column' => 'total_price', 'order' => true],
                    ['name' => 'Qty', 'column' => 'qty', 'order' => true],
                    ['name' => 'Materials', 'column' => 'materials', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['product_id'],
            'headers' => [
                    ['name' => 'Product id', 'column' => 'product_id'],
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Price', 'column' => 'price'],
                    ['name' => 'Total price', 'column' => 'total_price'],
                    ['name' => 'Qty', 'column' => 'qty'],
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
                        'label' => 'Product id',
                        'name' =>  'product_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('product_id', $id),
                        'value' => (isset($edit)) ? $edit->product_id : ''
                    ],
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
                        'label' => 'Total price',
                        'name' =>  'total_price',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('total_price', $id),
                        'value' => (isset($edit)) ? $edit->total_price : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Qty',
                        'name' =>  'qty',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('qty', $id),
                        'value' => (isset($edit)) ? $edit->qty : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Materials',
                        'name' =>  'materials',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('materials', $id),
                        'value' => (isset($edit)) ? $edit->materials : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'product_id' => 'required|string',
                    'name' => 'required|string',
                    'price' => 'required|string',
                    'total_price' => 'required|string',
                    'qty' => 'required|string',
                    'materials' => 'required|string',
        ];

        return $rules;
    }

}
