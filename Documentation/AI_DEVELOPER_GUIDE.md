# AI Features Developer Guide

## Architecture Overview

### Service-Controller-Model Pattern

```
┌─────────────────────────────────────────┐
│     User Interface (Blade Views)        │
└──────────────┬──────────────────────────┘
               │
┌──────────────▼──────────────────────────┐
│        Controllers                      │
│ - AIMaintenanceAlertController          │
│ - AIReportController                    │
└──────────────┬──────────────────────────┘
               │
┌──────────────▼──────────────────────────┐
│        Services                         │
│ - AIService (OpenAI Integration)        │
└──────────────┬──────────────────────────┘
               │
┌──────────────▼──────────────────────────┐
│        Models & Database                │
│ - AIMaintenanceAlert                    │
│ - AIReport                              │
│ - Vehicle, User, etc.                   │
└─────────────────────────────────────────┘
```

## AIService Class

### Purpose
Central service for all AI operations. Handles OpenAI API communication.

### Key Methods

```php
// Check if AI is enabled
$enabled = $aiService->isEnabled();

// Generate maintenance alert
$result = $aiService->generateMaintenanceAlert($vehicleData);

// Generate report analysis
$result = $aiService->generateReportAnalysis($reportData, $reportType);
```

### Response Format
```php
[
    'success' => true/false,
    'analysis' => [...],      // Parsed JSON response
    'raw_response' => string  // Full OpenAI response
]
```

## Adding New Alert Types

### Step 1: Update Model
Add new alert type to `AIMaintenanceAlert` model:

```php
const ALERT_TRANSMISSION_FLUID = 'transmission_fluid';

// Update getAlertTypes()
public static function getAlertTypes()
{
    return [
        // ... existing types
        self::ALERT_TRANSMISSION_FLUID => 'Transmission Fluid Change',
    ];
}
```

### Step 2: Update Database
Modify the migration enum:

```php
$table->enum('alert_type', [
    'oil_change',
    'tire_replacement',
    'brake_service',
    'battery',
    'filter',
    'transmission',
    'suspension',
    'transmission_fluid',  // New
    'other'
]);
```

### Step 3: Update AIService
Enhance the maintenance prompt generation:

```php
protected function buildMaintenancePrompt($vehicleData): string
{
    // Add logic to handle new alert type
    return "Analyze transmission fluid condition...";
}
```

## Adding New Report Types

### Step 1: Update Model
Add to `AIReport` model:

```php
const TYPE_TIRE_MANAGEMENT = 'tire_management';

public static function getReportTypes()
{
    return [
        // ... existing types
        self::TYPE_TIRE_MANAGEMENT => 'Tire Management Report',
    ];
}
```

### Step 2: Update Controller
Add data collection method in `AIReportController`:

```php
private function getTireManagementData($report)
{
    return TireManagement::whereBetween('created_at', [
        $report->report_period_from,
        $report->report_period_to,
    ])->with(['vehicle'])->get()->map(function ($item) {
        return [
            'vehicle' => $item->vehicle->registration_number,
            'tire_condition' => $item->condition,
            'usage_hours' => $item->hours_used,
            'cost' => $item->cost,
            'date' => $item->created_at,
        ];
    })->toArray();
}
```

### Step 3: Update Report Generation
Add case in `generateReportData()`:

```php
case AIReport::TYPE_TIRE_MANAGEMENT:
    $data = $this->getTireManagementData($report);
    break;
```

## Customizing AI Prompts

### Current Prompts
Located in `AIService` class:

1. **Maintenance Prompt** (`buildMaintenancePrompt()`)
2. **Report Analysis Prompt** (`buildReportAnalysisPrompt()`)

### Customizing Maintenance Analysis

```php
protected function buildMaintenancePrompt($vehicleData): string
{
    return "Analyze this vehicle maintenance data with focus on:\n" .
           "- Current mileage: " . $vehicleData['mileage'] . "\n" .
           "- Time since service: " . $vehicleData['service_interval'] . "\n" .
           "Consider the following:\n" .
           "1. Manufacturer recommendations\n" .
           "2. Vehicle age and usage patterns\n" .
           "3. Common issues for this make/model\n" .
           "4. Cost optimization\n";
}
```

### Customizing Report Analysis

```php
protected function buildReportAnalysisPrompt($reportData, $reportType): string
{
    $customPrompt = match($reportType) {
        'maintenance' => "Focus on maintenance trends and cost optimization...",
        'fuel_efficiency' => "Analyze fuel consumption patterns...",
        default => "Provide comprehensive fleet analysis..."
    };
    
    return $customPrompt . "\n\nData: " . json_encode($reportData);
}
```

## Alternative AI Providers

### Adding Anthropic (Claude)

1. **Install Package**:
```bash
composer require anthropic-ai/sdk
```

2. **Update Service**:
```php
// In AIService
protected $anthropicClient;

public function __construct()
{
    $this->anthropicClient = AnthropicClient(
        config('services.anthropic.api_key')
    );
}

public function generateMaintenanceAlertWithAnthropic($vehicleData)
{
    // Implementation
}
```

3. **Update Config**:
```php
// config/services.php
'anthropic' => [
    'api_key' => env('ANTHROPIC_API_KEY'),
    'model' => env('ANTHROPIC_MODEL', 'claude-3-sonnet'),
],
```

## Error Handling Best Practices

### API Error Handling
```php
try {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $this->apiKey,
    ])->post($url, $data);
    
    if (!$response->successful()) {
        Log::error('AI API Error: ' . $response->status(), [
            'body' => $response->json(),
            'request' => $data,
        ]);
        throw new \Exception('AI API Error: ' . $response->body());
    }
} catch (\Exception $e) {
    Log::error('AI Service Exception: ' . $e->getMessage());
    return ['success' => false, 'message' => $e->getMessage()];
}
```

### User-Friendly Errors
```php
// Don't expose raw API errors to users
if (!$result['success']) {
    return redirect()->back()->withErrors([
        'error' => 'Unable to generate analysis. Please try again later.'
    ]);
}
```

## Testing

### Unit Testing Example

```php
// tests/Unit/AIServiceTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AIService;

class AIServiceTest extends TestCase
{
    public function test_maintenance_alert_generation()
    {
        $service = new AIService();
        
        $vehicleData = [
            'registration_number' => 'TEST001',
            'make_model' => 'Toyota Camry',
            'age' => 5,
            'mileage' => 50000,
            'last_service' => '2024-03-01',
            'service_interval' => 5000,
        ];
        
        $result = $service->generateMaintenanceAlert($vehicleData);
        
        $this->assertTrue($result['success']);
        $this->assertIsArray($result['analysis']);
        $this->assertArrayHasKey('alert_type', $result['analysis']);
    }
}
```

### Feature Testing Example

```php
// tests/Feature/AIMaintenanceAlertTest.php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Vehicle;

class AIMaintenanceAlertTest extends TestCase
{
    public function test_user_can_generate_alert()
    {
        $this->actingAs($this->admin);
        
        $vehicle = Vehicle::factory()->create();
        
        $response = $this->post(route('ai-maintenance-alerts.generate'), [
            'vehicle_id' => $vehicle->id,
        ]);
        
        $response->assertRedirect(route('ai-maintenance-alerts.show', 1));
        $this->assertDatabaseHas('ai_maintenance_alerts', [
            'vehicle_id' => $vehicle->id,
        ]);
    }
}
```

## Performance Optimization

### Caching AI Responses
```php
// Cache frequently asked AI analyses
$cacheKey = 'ai_alert_' . $vehicle->id . '_' . date('Y-m-d');

$result = Cache::remember($cacheKey, 3600, function() use ($vehicle) {
    return $this->aiService->generateMaintenanceAlert($vehicleData);
});
```

### Batch Processing
```php
// Generate alerts for multiple vehicles
public function generateBatchAlerts(array $vehicleIds)
{
    foreach ($vehicleIds as $vehicleId) {
        // Throttle API calls
        sleep(1);
        $this->generate(new Request(['vehicle_id' => $vehicleId]));
    }
}
```

### Database Query Optimization
```php
// Use eager loading
$alerts = AIMaintenanceAlert::with(['vehicle', 'createdBy'])
    ->latest()
    ->paginate(50);
```

## Extension Points

### Event-Driven Architecture
Add events when new alerts are generated:

```php
// In AIMaintenanceAlertController
event(new \App\Events\MaintenanceAlertGenerated($alert));

// Create listener in app/Listeners/AlertNotificationListener.php
public function handle(MaintenanceAlertGenerated $event)
{
    $event->alert->vehicle->owner->notify(
        new AlertNotification($event->alert)
    );
}
```

### Observer Pattern
```php
// app/Observers/AIMaintenanceAlertObserver.php
public function created(AIMaintenanceAlert $alert)
{
    // Log creation
    // Send notifications
    // Trigger workflows
}

// Register in AppServiceProvider
AIMaintenanceAlert::observe(AIMaintenanceAlertObserver::class);
```

## Webhook Integration

### Sending Alerts to External Systems

```php
class AlertNotificationListener
{
    public function handle(MaintenanceAlertGenerated $event)
    {
        // Send to external maintenance system
        Http::post('https://external-system.com/alerts', [
            'alert' => $event->alert->toArray(),
            'timestamp' => now(),
        ]);
    }
}
```

## Monitoring & Logging

### Track API Usage
```php
Log::channel('ai-usage')->info('AI Alert Generated', [
    'vehicle_id' => $alert->vehicle_id,
    'type' => $alert->alert_type,
    'cost_estimate' => $alert->estimated_cost,
    'processing_time' => now()->diffInSeconds($startTime),
]);
```

### Monitor Costs
```php
// In schedule
protected function schedule(Schedule $schedule)
{
    $schedule->daily()->call(function () {
        $cost = $this->calculateDailyAICost();
        Log::channel('ai-costs')->warning('Daily AI Cost: $' . $cost);
    });
}
```

## API Rate Limiting

### Implement Queue-Based Processing
```bash
php artisan queue:work
```

```php
// In controller
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateAIReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue;
    
    public function handle()
    {
        // Long-running AI task
    }
}

// In controller
GenerateAIReport::dispatch($report);
```

## Debugging Tips

### Enable Query Logging
```php
// In tinker or controller
DB::enableQueryLog();

// ... your code ...

dd(DB::getQueryLog());
```

### Test AI Service Directly
```bash
php artisan tinker

> $service = new App\Services\AIService();
> $service->isEnabled()
> $result = $service->generateMaintenanceAlert([...])
> dd($result)
```

### Check API Communication
```php
// Enable guzzle debugging
'debug' => true,
'verify' => false, // For development only!
```

## Security Considerations

### API Key Protection
- Never log API keys
- Rotate keys regularly
- Use environment variables
- Restrict key permissions

### Input Validation
```php
// Validate before sending to AI
$validated = $request->validate([
    'vehicle_id' => 'required|exists:vehicles,id',
    // ...
]);
```

### Output Sanitization
```php
// Sanitize AI responses before displaying
$recommendation = Purifier::clean($alert->recommendation);
```

---

**For Questions or Issues**: Check logs in `storage/logs/laravel.log`
