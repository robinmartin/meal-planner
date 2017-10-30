<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class EloquentBuilder extends Builder
{
    /**
     * Eager load pivot relations.
     *
     * @param  array $models
     * @return void
     */
    protected function loadPivotRelations($models)
    {
        $query = head($models)->pivot->newQuery()->with('unit');
        $pivots = array_pluck($models, 'pivot');
        $pivots = head($pivots)->newCollection($pivots);

        $pivots->load($this->getPivotRelations());
    }

    /**
     * Get the pivot relations to be eager loaded.
     *
     * @return array
     */
    protected function getPivotRelations()
    {
        $relations = array_filter(array_keys($this->eagerLoad), function ($relation) {
            return $relation != 'pivot' && str_contains($relation, 'pivot');
        });

        return array_map(function ($relation) {
            return substr($relation, strlen('pivot.'));
        }, $relations);
    }

    /**
     * Override. Eager load relations of pivot models.
     * Eagerly load the relationship on a set of models.
     *
     * @param  array     $models
     * @param  string    $name
     * @param  \Closure  $constraints
     * @return array
     */
    protected function eagerLoadRelation(array $models, $name, \Closure $constraints)
    {
        // In this part, if the relation name is 'pivot',
        // therefore there are relations in a pivot to be eager loaded.
        if ($name === 'pivot') {
            $this->loadPivotRelations($models);
            return $models;
        }

        return parent::eagerLoadRelation($models, $name, $constraints);
    }
}