<?php

namespace Leofranca47\AbstractRepositoryEloquent;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractEloquentRepository
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var
     */
    protected $wheres;
    /**
     * @var
     */
    protected $query;

    /**
     *
     */
    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    /**
     * @return Model
     */
    abstract protected function resolveModel(): Model;

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id, $data): bool
    {
        $this->unMountQuery();
        return $this->model->find($id)->update($data);
    }

    /**
     * @param $id
     * @return string[]
     */
    public function deleteById($id): array
    {
        $this->model->find($id)->delete();

        return [
            'message' => 'deleted'
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $this->unMountQuery();
        return $this->model->findOrFail($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $this->unMountQuery();
        return $this->model->create($data);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $this->unMountQuery();
        return $this->model->all();
    }

    /**
     * @param  string  $column
     * @param  string  $value
     * @param  string  $operator
     * @return $this
     */
    public function where(string $column, string $value, string $operator = '=')
    {
        $this->wheres[] = compact('column', 'value', 'operator');
        return $this;
    }

    /**
     * @param  string  $column
     * @return $this
     */
    public function whereNotNull(string $column)
    {
        $value = '';
        $operator = "<>";
        $this->wheres[] = compact('column', 'value', 'operator');
        return $this;
    }

    /**
     * @param  array  $columns
     * @return mixed
     */
    public function first(array $columns = ['*'])
    {
        $this->newQuery()->mountWhere();
        $model = $this->query->firstOrFail($columns);
        $this->unMountQuery();
        return $model;
    }

    /**
     * @param  array  $columns
     * @return mixed
     */
    public function get(array $columns = ['*'])
    {
        $this->newQuery()->mountWhere();
        $models = $this->query->get($columns);
        $this->unMountQuery();
        return $models;
    }

    /**
     * @param  array  $columns
     * @return int
     */
    public function count(array $columns = ['*']): int
    {
        $this->newQuery()->mountWhere();
        $models = $this->query->get($columns);
        $this->unMountQuery();
        return count($models);
    }

    /**
     * @param  array  $attributes
     * @param  array  $options
     * @return mixed
     */
    public function update(array $attributes = [], array $options = [])
    {
        $this->unMountQuery();
        return $this->model->update($attributes, $options);
    }

    /**
     * @return $this
     */
    protected function newQuery()
    {
        $this->query = $this->model->newQuery();
        return $this;
    }

    /**
     * @return $this
     */
    protected function mountWhere()
    {
        if (!is_array($this->wheres)) {
            return $this->query;
        }

        foreach ($this->wheres as $where) {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }

        return $this;
    }

    /**
     * @return void
     */
    protected function unMountQuery()
    {
        $this->wheres = null;
        $this->query = null;
    }
}
