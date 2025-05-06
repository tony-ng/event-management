<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait CanLoadRelationships {

    public function loadRelationships(
        Model|EloquentBuilder|QueryBuilder|HasMany $for,
        ?array $relations = null
    ) {
        $relations = $relations ?? $this->relations ?? [];

        foreach($relations as $relation){
            $for->when($this->shouldIncludeRelation($relation),
                function($q) use ($for, $relation) {
                    $for instanceof Model ? $for->load($relation) : $q->with($relation);
                }
            );
        }

        return $for;
    }

    protected function shouldIncludeRelation(string $relation){
        $includes = request()->query('include');

        if (!$includes){
            return false;
        }

        return in_array($relation, array_map('trim', explode(',', $includes)));
    }
}