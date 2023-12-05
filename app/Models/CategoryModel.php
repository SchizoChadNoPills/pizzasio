<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Category;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'name', 'icon', 'id_step'
    ];
    protected $useTimestamps = false;

    public function getAllCategory()
    {
        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }
    public function getCategoryById($id)
    {
        return $this->find($id);
    }

    public function getCategoryByIdStep($id_step)
    {
        return $this->where('id_step', $id_step)->get()->getResultArray();
    }

    public function createCategory(Category $category)
    {
        return $this->insert($category);
    }

    public function updateCategory(Category $category)
    {
        return $this->update($category->getId(), $category);
    }

    public function deleteCategory($id)
    {
        return $this->delete($id);
    }

    public function getPaginatedCategory($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();

        // Recherche

        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orLike('name', $searchValue);
            $builder->orLike('icon', $searchValue);
        }
        // Tri

        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray();
    }
    public function getTotalCategory()
    {

        return $this->builder()->countAllResults();
    }

    public function getFilteredCategory($searchValue)

    {
        $builder = $this->builder();

        // @phpstan-ignore-next-line

        if (!empty($searchValue)) {

            $builder->like('id', $searchValue);

            $builder->orlike('name', $searchValue);

            $builder->orLike('icon', $searchValue);
        }
        return $builder->countAllResults();
    }
}
