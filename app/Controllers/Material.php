<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Material as MaterialModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Material extends ResourceController
{
    protected $model;
    
    public function __construct() 
    {
        $this->model = new MaterialModel();
    }

    public function index()
    {
        return "aaa";
    }

    public function create()
    {
        $data = [
            'code'          => $this->request->getVar('code'),
            'name'          => $this->request->getVar('name'),
            'price_buy'     => $this->request->getVar('price_buy'),
            'material_type' => $this->request->getVar('material_type'),
            'supplier'      => $this->request->getVar('supplier'),
        ];

        $this->model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Material created successfully'
            ]
        ];
        
        return $this->respondCreated($response);
    }
}
