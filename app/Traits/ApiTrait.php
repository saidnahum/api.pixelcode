<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApiTrait {

    public function scopeIncluded(Builder $query){

        // Ejemplo de consulta de ScopeIncluded, son las unicas permitidas
        // http://127.0.0.1:8000/v1/categories?included=posts
        // http://127.0.0.1:8000/v1/categories?included=posts.user
        
        // Preguntar si no se ha definido la variable included en la URL para así si no se ha
        // declarado la variable retorne el valor por defecto
        if(empty($this->allowIncluded) || empty(request('included'))){
            return;
        }

        // Recuperar la relación que el cliente ha mandado por la URL, con el método explode
        // separamos las relaciones enviadas por la URL en un arreglo separado por comas (,)
        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        // Iterar las relaciones para saber cuales consultas estan en la URL y de no estar
        // eliminarlas de la consulta y dejar las que se mandaron solo por URL
        foreach($relations as $key => $relationship){
            if(!$allowIncluded->contains($relationship)){
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }

    public function scopeFilter(Builder $query){

        // Ejemplo de consulta de ScopeFiler, son las unicas permitidas
        // http://127.0.0.1:8000/v1/categories?filter[name]=e
        // http://127.0.0.1:8000/v1/categories?filter[name]=e&filter[id]=4
    

        // Preguntar si es que se está definiendo un propiedad allowFilter con los posibles tipos
        // de filtros y preguntar también si se está definiendo un filtro por la URL

        if(empty($this->allowFilter) || empty(request('filter'))){
            return;
        }

        // Rescatando peticion de filter por la URL
        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach($filters as $filter => $value){
            if($allowFilter->contains($filter)){
                // Consulta
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
        }
    }

    public function scopeSort(Builder $query){
        
        if(empty($this->allowSort) || empty(request('sort'))){
            return;
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach($sortFields as $sortField){

            $direction = 'asc';

            if(substr($sortField, 0, 1) == '-'){
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }

            if($allowSort->contains($sortField)){
                $query->orderBy($sortField, $direction);
            }
        }
    }

    public function scopegetOrPaginate(Builder $query){
        if(request('perPage')){
            $perPage = intval(request('perPage'));

            if($perPage){
                return $query->paginate($perPage); 
            }
        }

        return $query->get();
    }
}