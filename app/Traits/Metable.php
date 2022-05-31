<?php

namespace App\Traits;

use App\Models\Meta;

trait Metable
{
    protected static function bootMetable()
    {
        static::deleted(function ($metable) {
            $metable->meta()->delete();
        });
    }

    public function meta()
    {
        return $this->morphMany(Meta::class, 'parent');
    }

    public function getMetadataAttribute()
    {
        $metadata = [];
        foreach ($this->meta()->get() as $meta) {
            $metadata[$meta->name] = $meta->value;
        }
        return $metadata;
    }

    public function getMeta($name)
    {
        if ($meta = $this->meta()->byName($name)->first()) {
            return $meta->value;
        }
    }

    public function setMeta($name, $value)
    {
        if ($meta = $this->meta()->byName($name)->first()) {
            return $meta->update(['value' => $value]);
        } else {
            $meta = new Meta(['name' => $name, 'value' => $value]);
            $meta->parent()->associate($this);
            return $meta->save();
        }
    }

    public function setMetadataAttribute($values)
    {
        if (is_array($values) && count($values) > 0) {
            foreach ($values as $name => $value) {
                $this->setMeta($name, $value);
            }
        }
    }
}
