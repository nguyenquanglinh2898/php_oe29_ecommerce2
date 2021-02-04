<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function assertBelongsTo($model, $relationName, $related, $foreignKey, $ownerKey)
    {
        $relation = $model->$relationName();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf($related, $relation->getRelated());
        $this->assertEquals($foreignKey, $relation->getForeignKeyName());
        $this->assertEquals($ownerKey, $relation->getOwnerKeyName());
    }

    protected function assertBelongsToMany($model, $relationName, $related, $foreignKey, $relateKey)
    {
        $relation = $model->$relationName();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertInstanceOf($related, $relation->getRelated());
        $this->assertEquals($foreignKey, $relation->getForeignPivotKeyName());
        $this->assertEquals($relateKey, $relation->getRelatedPivotKeyName());
    }

    protected function assertHasOne($model, $relationName, $related, $foreignKey, $localKey)
    {
        $relation = $model->$relationName();
        $this->assertInstanceOf(HasOne::class, $relation);
        $this->assertInstanceOf($related, $relation->getRelated());
        $this->assertEquals($foreignKey, $relation->getForeignKeyName());
        $this->assertEquals($localKey, $relation->getLocalKeyName());
    }

    protected function assertHasMany($model, $relationName, $related, $foreignKey, $localKey)
    {
        $relation = $model->$relationName();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf($related, $relation->getRelated());
        $this->assertEquals($foreignKey, $relation->getForeignKeyName());
        $this->assertEquals($localKey, $relation->getLocalKeyName());
    }

    protected function assertMorphMany($model, $relationName, $related, $morphKey, $morphType)
    {
        $relation = $model->$relationName();
        $this->assertInstanceOf(MorphMany::class, $relation);
        $this->assertInstanceOf($related, $relation->getRelated());
        $this->assertEquals($morphKey, $relation->getForeignKeyName());
        $this->assertEquals($morphType, $relation->getMorphType());
    }

    protected function assertMorphTo($model, $relationName)
    {
        $relation = $model->$relationName();
        $this->assertInstanceOf(MorphTo::class, $relation);
    }
}
