<?php

namespace JrSmith\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/** @mixin Model */
trait UuidPrimary
{
    protected string $uuidKeyType = 'string';

    public static function bootUuidPrimary()
    {
        static::creating(function (Model $model) {
            /** @var UuidPrimary $model */
            $uuidKey = $model->getKeyName();
            if (empty($model->attributes[$uuidKey])) {
                $model->attributes[$uuidKey] = $model->createUuid();
            }
        });
        static::saving(function (Model $model) {
            /** @var UuidPrimary $model */
            $uuidKey = $model->getKeyName();
            if (empty($model->attributes[$uuidKey])) {
                $model->attributes[$uuidKey] = $model->createUuid();
            }
        });
    }

    public function createUuid(): string
    {
        return Str::uuid()->toString();
    }

    public function scopeByUuid($query, $uuid)
    {
        return $query->where($this->getKeyName(), $uuid);
    }

    public static function findByUuid($uuid): ?static
    {
        return static::query()->firstWhere($uuid);
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return $this->uuidKeyType;
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
}
