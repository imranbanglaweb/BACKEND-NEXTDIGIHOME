<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'subject',
        'body',
        'type',
        'variables',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean'
    ];

    // Template type constants for requisition workflow
    public const TYPE_CREATED = 'requisition_created';
    public const TYPE_DEPT_APPROVED = 'dept_approved';
    public const TYPE_TRANSPORT_APPROVED = 'transport_approved';

    /**
     * Get all available template types
     */
    public static function getTemplateTypes(): array
    {
        return [
            self::TYPE_CREATED => 'Requisition Created',
            self::TYPE_DEPT_APPROVED => 'Department Approved',
            self::TYPE_TRANSPORT_APPROVED => 'Transport Approved',
        ];
    }

    /**
     * Scope active templates only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by template type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Find template by slug
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->active()->first();
    }

    /**
     * Find template by type
     */
    public static function findByType(string $type): ?self
    {
        return static::ofType($type)->active()->first();
    }

    /**
     * Get available variables for this template
     */
    public function getAvailableVariables(): array
    {
        return $this->variables ?? [];
    }

    /**
     * Replace variables in template body and subject
     */
    public function render(array $data): array
    {
        $subject = $this->subject;
        $body = $this->body;
        
        // Decode HTML entities that CKEditor might have added
        $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');
        $body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
        
        // Also handle common HTML entity conversions for curly braces
        $subject = str_replace(['&lbrace;', '&rbrace;', '&#123;', '&#125;'], ['{', '}', '{', '}'], $subject);
        $body = str_replace(['&lbrace;', '&rbrace;', '&#123;', '&#125;'], ['{', '}', '{', '}'], $body);
        
        // Remove blade-style comments {{-- comment --}}
        $body = preg_replace('/\{\{--.*?--\}\}/s', '', $body);
        $subject = preg_replace('/\{\{--.*?--\}\}/s', '', $subject);
        
        // First, handle conditional blocks: {{#if variable}} ... {{/if}}
        // These blocks are kept if variable has a non-null/non-empty value, removed otherwise
        preg_match_all('/\{\{#if\s+(\w+)\}\}(.*?)\{\{\/if\}\}/s', $body, $conditionals);
        foreach ($conditionals[0] as $index => $fullMatch) {
            $variable = $conditionals[1][$index];
            $content = $conditionals[2][$index];
            
            // Check if variable exists and has a non-null/non-empty value
            $hasValue = isset($data[$variable]) && !empty($data[$variable]);
            
            if ($hasValue) {
                // Keep the content, but remove the conditional tags
                $body = str_replace($fullMatch, $content, $body);
            } else {
                // Remove the entire conditional block
                $body = str_replace($fullMatch, '', $body);
            }
        }
        
        // Then replace all variables
        foreach ($data as $key => $value) {
            // Support both {{variable}} and @{{variable}} formats
            $placeholders = [
                '{{' . $key . '}}',
                '@{{' . $key . '}}',
                '{{ ' . $key . ' }}',
                '@{{ ' . $key . ' }}'
            ];
            // Convert value to string for replacement
            $stringValue = is_null($value) ? '' : (is_array($value) ? json_encode($value) : (string)$value);
            $subject = str_replace($placeholders, $stringValue, $subject);
            $body = str_replace($placeholders, $stringValue, $body);
        }

        return [
            'subject' => $subject,
            'body' => $body
        ];
    }
}
