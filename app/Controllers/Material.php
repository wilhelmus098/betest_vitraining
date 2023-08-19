<?php

namespace App\Controllers;

use App\Models\Material as MaterialModel;
use CodeIgniter\RESTful\ResourceController;

class Material extends ResourceController
{
    protected $model;
    
    public function __construct() 
    {
        $this->model = new MaterialModel();
    }

    public function index()
    {
        $params = '';
        $url = parse_url($_SERVER["REQUEST_URI"]);
        if(isset($url["query"])){
            parse_str($url["query"], $params);
        }

        $data = $this->model->materialWithRelatedData($params["filter"]);
        $response = [
            "status"  => 201,
            "error"   => false,
            "message" => "success",
            "data"    => $data
        ];
        return $this->respond($response);
    }

    public function create()
    {
        $rules = [
            "code"          => "required|max_length[10]|is_unique[materials.code]",
            "name"          => "required|max_length[255]",
            "price_buy"     => "required|numeric|greater_than[99]",
            "material_type" => "required|is_natural|is_not_unique[material_types.id]",
            "supplier"      => "required|is_natural|is_not_unique[suppliers.id]"
        ];
		$messages = [
			"code" => [
				"required"   => "Code is required",
                "max_length" => "Max code allowed is 10",
                "is_unique"  => "Material with the same code is exist"
            ],
            "name" => [
                "required"   => "Name is required",
                "max_length" => "Max name allowed is 255"
            ],
            "price_buy" => [
                "required"      => "price_buy is required",
                "numeric"       => "Only numeric value allowed",
                "greater_than"  => "value must be greater than 99"
            ],
            "material_type" => [
                "required"      => "material_type is required",
                "is_natural"    => "Only natural number value allowed",
                "is_not_unique" => "Specified material type doesn't exist"
            ],
            "supplier" => [
                "required"      => "supplier is required",
                "is_natural"    => "Only natural number value allowed",
                "is_not_unique" => "Specified supplier doesn't exist"
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
            "code"          => $this->request->getVar("code"),
            "name"          => $this->request->getVar("name"),
            "price_buy"     => $this->request->getVar("price_buy"),
            "material_type" => $this->request->getVar("material_type"),
            "supplier"      => $this->request->getVar("supplier"),
        ];

        $material = $this->model->insert($data);
        $response = [
            "status"   => 201,
            "error"    => false,
            "messages" => "Material created successfully",
            "data"     => $material
        ];

        return $this->respond($response);
    }

    public function update($id = null)
    {
        $rules = [
            "name"          => "required|max_length[255]",
            "price_buy"     => "required|numeric|greater_than[99]",
            "material_type" => "required|is_natural|is_not_unique[material_types.id]",
            "supplier"      => "required|is_natural|is_not_unique[suppliers.id]"
        ];
		$messages = [
            "name" => [
                "required"   => "Name is required",
                "max_length" => "Max name allowed is 255"
            ],
            "price_buy" => [
                "required"      => "price_buy is required",
                "numeric"       => "Only numeric value allowed",
                "greater_than"  => "value must be greater than 99"
            ],
            "material_type" => [
                "required"      => "material_type is required",
                "is_natural"    => "Only natural number value allowed",
                "is_not_unique" => "Specified material type doesn't exist"
            ],
            "supplier" => [
                "required"      => "supplier is required",
                "is_natural"    => "Only natural number value allowed",
                "is_not_unique" => "Specified supplier doesn't exist"
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
            "name"          => $this->request->getVar("name"),
            "price_buy"     => $this->request->getVar("price_buy"),
            "material_type" => $this->request->getVar("material_type"),
            "supplier"      => $this->request->getVar("supplier"),
        ];
        
        $material = $this->model->update($id, $data);
        $response = [
          "status"   => 200,
          "error"    => false,
          "messages" => "Material updated successfully",
          "data"     => $material
        ];
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            $this->model->delete($id);
            $response = [
                "status"   => 200,
                "error"    => false,
                "messages" => "Material deleted successfully",
                "data"     => $data
            ];

            return $this->respond($response);
        } else {
            $response = [
                "status"   => 500,
                "error"    => true,
                "messages" => "Specified material doesn't exist.",
                "data"     => []
            ];

            return $this->respond($response);
        }
    }
}
