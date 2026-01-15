<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'command',
        'description',
        'parameters',
        'visibility',
    ];

    protected $casts = [
        'parameters' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resolveCommand(array $inputParams = []): string
    {
        $defaults = $this->parameters ?? [];

        // Normalize all keys to uppercase for case-insensitive matching
        $params = array_change_key_case($defaults, CASE_UPPER);
        $inputs = array_change_key_case($inputParams, CASE_UPPER);

        // Merge defaults with inputs (inputs override defaults)
        $merged = array_merge($params, $inputs);

        // Replace {$VAR} patterns
        return preg_replace_callback('/\{\$([a-zA-Z0-9_]+)\}/', function ($matches) use ($merged) {
            $key = strtoupper($matches[1]);
            return $merged[$key] ?? $matches[0];
        }, $this->command);
    }
}
