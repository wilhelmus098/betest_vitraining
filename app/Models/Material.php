<?php

namespace App\Models;

use CodeIgniter\Model;

class Material extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'materials';
    protected $primaryKey       = 'code';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code','name','price_buy','material_type','supplier'];

    public function materialWithRelatedData($filter = null)
    {
        $builder = $this->db->table('materials m');
        $builder->select('m.*, s.name as supplier_name, mt.name as material_type_name');
        $builder->join('suppliers s', 's.id = m.supplier');
        $builder->join('material_types mt', 'mt.id = m.material_type');
        
        if($filter != null) {
            $builder->whereIn('material_type', $filter);
        }
        $query = $builder->get();

        return $query->getResult();
    }
}
