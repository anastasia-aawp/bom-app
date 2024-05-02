<?php

namespace App\Http\Controllers;

use App\Models\StockMaterial;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use App\Models\MstMaterial;

class StockMaterialController extends DefaultController
{
    protected $modelClass = StockMaterial::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Stock Material';
        $this->generalUri = 'stock-material';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Material id', 'column' => 'material_id', 'order' => true],
                    ['name' => 'Qty', 'column' => 'qty', 'order' => true],
                    ['name' => 'Type', 'column' => 'type', 'order' => true],
                    ['name' => 'Notes', 'column' => 'notes', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['material_id'],
            'headers' => [
                    ['name' => 'Material id', 'column' => 'material_id'],
                    ['name' => 'Qty', 'column' => 'qty'],
                    ['name' => 'Type', 'column' => 'type'],
                    ['name' => 'Notes', 'column' => 'notes'], 
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
                        'type' => 'select',
                        'label' => 'Material id',
                        'name' => 'material_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('material_id', $id),
                        'value' => (isset($edit)) ? $edit->material_id : '',
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
                        'type' => 'select',
                        'label' => 'Type',
                        'name' => 'type',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('type', $id),
                        'value' => (isset($edit)) ? $edit->type : '',
                        'options' => [
                        ['value' => 'in', 'text' => 'in'],
                        ['value' => 'out', 'text' => 'out'],
                        ]
                    ],
                    [
                        'type' => 'number',
                        'label' => 'jumlah',
                        'name' =>  'qty',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('type', $id),
                        'value' => (isset($edit)) ? $edit->type : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Notes',
                        'name' =>  'notes',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('notes', $id),
                        'value' => (isset($edit)) ? $edit->notes : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'material_id' => 'required|string',
                    'qty' => 'required|string',
                    'type' => 'required|string',
                    'notes' => 'required|string',
        ];

        return $rules;
    }

    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = null;
        $orderBy = 'id';
        $orderState = 'DESC';
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }
        $dataQueries = $this->modelClass::where($filters)
            ->join('mst_materials', 'mst_materials.id', 'stock_materials.material_id')
            ->select('stock_materials.*', 'mst_materials.name as material_name')
            ->where(function ($query) use ($orThose) {
        $query->where('mst_materials.name', 'LIKE', '%'
        . $orThose .
        '%');
        $query->orWhere('notes', 'LIKE', '%'
        . $orThose .
        '%');
        })
        ->orderBy($orderBy, $orderState);
        return $dataQueries;
        }

}
