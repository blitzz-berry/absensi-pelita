<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'key',
        'value',
        'type',
    ];
    
    /**
     * Get the value attribute based on the type
     */
    public function getValueAttribute($value)
    {
        $type = $this->attributes['type'] ?? 'string';
        
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }
    
    /**
     * Set the value attribute based on the type
     */
    public function setValueAttribute($value)
    {
        $type = $this->attributes['type'] ?? 'string';
        
        switch ($type) {
            case 'boolean':
                $value = $value ? '1' : '0';
                break;
            case 'integer':
                $value = (string) (int) $value;
                break;
            case 'json':
                $value = json_encode($value);
                break;
            default:
                $value = (string) $value;
                break;
        }
        
        $this->attributes['value'] = $value;
    }
    
    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
    
    /**
     * Set setting value by key
     */
    public static function set($key, $value, $type = 'string')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
        
        return $setting;
    }
}
