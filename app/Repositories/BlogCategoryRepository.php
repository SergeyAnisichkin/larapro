<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogCategoryRepository
 *
 * @package App\Repositories
 */
class BlogCategoryRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Получить модель для редактирования в админке
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getEdit(int $id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Получить список для вывода в выпадающем списке
     *
     * @return Collection
     */
    public function getForComboBox()
    {
        $columns = implode(', ', ['id', 'CONCAT (id, ". ", title) AS id_title']);

        return $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();
    }

    /**
     * Получить список для вывода c пагинацией
     *
     * @param int $perPage
     *
     * @return Collection
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];
         $result = $this
             ->startConditions()
             ->paginate($perPage, $columns);

        return $result;
    }

}
