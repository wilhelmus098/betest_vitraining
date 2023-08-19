<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialType as MaterialTypeModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class MaterialType extends ResourceController
{
    protected $model;
    
    public function __construct() 
    {
        $this->model = new MaterialTypeModel();
    }

    public function index()
    {
        $data = $this->model->orderBy("id", "DESC")->findAll();
        return $this->respond($data);
    }

    public function create()
    {
        $rules = ["name" => "required|max_length[255]"];
		$messages = [
			"name" => [
				"required" => "Name is required",
                "max_length" => "Max name allowed is 255"
			]
		];

        if (!$this->validate($rules, $messages)) {
			$response = [
				"status"  => 500,
				"error"   => true,
				"message" => $this->validator->getErrors(),
				"data"    => []
			];
            return $this->respond($response);
		}

        $data = [
            "name"  => $this->request->getVar("name")
        ];

        $materialType = $this->model->insert($data);
        $response = [
            "status"   => 201,
            "error"    => null,
            "messages" => "Material type successfully created",
            "data"     => $materialType
        ];

        return $this->respond($response);
    }
}
