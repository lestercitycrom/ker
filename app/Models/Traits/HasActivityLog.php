<?php

namespace App\Models\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Arr;

/**
 * Trait HasActivityLog
 *
 * Default configuration for Spatie activity logging,
 * with options to ignore attributes, log only dirty, and
 * custom descriptions.
 */
trait HasActivityLog
{
    use LogsActivity;

    /**
     * Attributes to ignore by default.
     *
     * @var string[]
     */
    protected static array $activityLogIgnore = [
        'updated_at',
        'deleted_at',
    ];

    /**
     * Whether to log only changed attributes.
     *
     * @var bool
     */
    protected static bool $activityLogOnlyDirty = true;

    /**
     * Build default LogOptions.
     */
    public function getActivitylogOptions(): LogOptions
    {
        $options = LogOptions::defaults()
            // Log all fillable attributes
            ->logAll()
            // Ignore service fields
            ->logExcept(static::$activityLogIgnore)
            // Do not submit empty logs
            ->dontSubmitEmptyLogs()
            // Set log name as model table
            ->useLogName($this->getTable());

        if (static::$activityLogOnlyDirty) {
            $options->logOnlyDirty();
        }

        return $options;
    }

    /**
     * Provide a human-readable description for each event.
     */
    public function getDescriptionForEvent(string $event): string
    {
        // Try translation: activity_log.{table}.{event}
        $key = "activity_log.{$this->getTable()}.{$event}";

        if (trans()->has($key)) {
            return trans($key, ['name' => $this->{$this->getKeyName()}]);
        }

        // Fallback
        return ucfirst($event) . " «{$this->getTable()}»";
    }

    /**
     * Optionally add extra properties (IP, UserAgent).
     */
    public function tapActivity(\Spatie\Activitylog\Models\Activity $activity, string $event): void
    {
        // Set properties directly instead of withProperties()
        $activity->properties = [
            'ip'    => request()->ip(),
            'agent' => substr(request()->userAgent() ?? '', 0, 255),
        ];
        // Не обязательно явно вызывать $activity->save() — оно сохранится автоматически
    }
}
