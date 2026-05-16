# AI Features Implementation Guide for VMS System

## Overview
This document outlines the implementation of two new AI-powered modules for your Vehicle Management System:
1. **Maintenance Alerts with AI** - Predictive maintenance alerts powered by OpenAI
2. **Reporting with AI** - AI-powered fleet analytics and reporting

## Features Implemented

### 1. AI Maintenance Alerts
- **Predictive Analysis**: AI analyzes vehicle data and predicts maintenance needs
- **Alert Management**: Track, update, and manage maintenance alerts
- **Priority Levels**: Critical, High, Medium, Low
- **Cost Estimation**: AI estimates maintenance costs
- **Urgency Scoring**: 1-5 scale urgency level
- **Status Tracking**: Pending → Acknowledged → Scheduled → Completed

**Capabilities:**
- Oil changes, tire replacement, brake service, battery, filters, transmission, suspension
- Vehicle history analysis
- Mileage-based recommendations
- Cost optimization
- Automated notifications

### 2. AI-Powered Reports
- **Multiple Report Types**:
  - Maintenance Analysis
  - Fuel Efficiency Report
  - Driver Performance Report
  - Fleet Health Report
  - Cost Analysis Report
  - Custom Reports

- **AI Analysis**: Executive summaries, key findings, recommendations
- **Data Processing**: Aggregates fleet data for analysis
- **Report Generation**: Scheduled or on-demand
- **Export Options**: PDF downloads
- **Archive Management**: Store and retrieve historical reports

## Files Created

### Models
- `app/Models/AIMaintenanceAlert.php` - Maintenance alert model
- `app/Models/AIReport.php` - Report model

### Controllers
- `app/Http/Controllers/AIMaintenanceAlertController.php`
- `app/Http/Controllers/AIReportController.php`

### Services
- `app/Services/AIService.php` - AI integration service

### Migrations
- `database/migrations/2026_04_02_000001_create_ai_maintenance_alerts_table.php`
- `database/migrations/2026_04_02_000002_create_ai_reports_table.php`
- `database/migrations/2026_04_02_000003_add_ai_features_menu.php`

### Views
- `resources/views/admin/ai-maintenance-alerts/index.blade.php`
- `resources/views/admin/ai-maintenance-alerts/show.blade.php`
- `resources/views/admin/ai-maintenance-alerts/edit.blade.php`
- `resources/views/admin/ai-reports/index.blade.php`
- `resources/views/admin/ai-reports/create.blade.php`
- `resources/views/admin/ai-reports/show.blade.php`

### Configuration
- Updated `config/services.php` with OpenAI configuration

### Routes
- Added in `routes/web.php` under section 23

## Setup Instructions

### Step 1: Install Required Packages

```bash
composer require guzzlehttp/guzzle
```

### Step 2: Update Environment File

Add the following to your `.env` file:

```env
# OpenAI Configuration
OPENAI_API_KEY=sk_your_openai_api_key_here
OPENAI_MODEL=gpt-3.5-turbo
AI_FEATURES_ENABLED=true
```

**Note**: Get your API key from https://platform.openai.com/api-keys

### Step 3: Run Migrations

```bash
php artisan migrate
```

This will:
- Create `ai_maintenance_alerts` table
- Create `ai_reports` table
- Add menu items to the admin menu

### Step 4: Clear Cache

```bash
php artisan cache:clear
php artisan config:cache
```

### Step 5: Grant Permissions (Optional)

Add the following permissions to your roles if using permission-based access control:

```php
// In your permission setup or seeder
'ai-maintenance-alerts-view'
'ai-maintenance-alerts-create'
'ai-maintenance-alerts-edit'
'ai-maintenance-alerts-delete'
'ai-reports-view'
'ai-reports-create'
'ai-reports-download'
'ai-reports-delete'
```

## Usage Guide

### AI Maintenance Alerts

#### 1. Generate New Alert
- Navigate to **AI Features → Maintenance Alerts (AI)**
- Click **"Generate New Alert"** button
- The system will:
  1. Analyze vehicle data (mileage, age, service history)
  2. Contact OpenAI for predictive analysis
  3. Create an alert with recommendations

#### 2. View Alert Details
- Click on any alert to see:
  - Vehicle information
  - Alert type and priority
  - AI-generated recommendation
  - Urgency level (visual progress bar)
  - Estimated costs
  - Full AI analysis JSON

#### 3. Manage Alerts
- **Edit**: Update priority, status, recommendation, or schedule maintenance
- **Mark as Completed**: Move alert to completed status
- **Delete**: Remove dismissed or completed alerts
- **Filter**: By status, priority, vehicle, or alert type

#### 4. Dashboard View
- View statistics:
  - Total alerts count
  - Pending alerts
  - Critical alerts
  - Completed alerts
- See alert breakdown by type
- View recent alerts

### AI Reports

#### 1. Generate New Report
- Navigate to **AI Features → AI Reports**
- Click **"Generate New Report"** button
- Select report type:
  - **Maintenance Analysis**: Maintenance patterns and predictions
  - **Fuel Efficiency**: Fuel consumption optimization
  - **Driver Performance**: Driver behavior and metrics
  - **Fleet Health**: Overall vehicle condition assessment
  - **Cost Analysis**: Financial breakdown and insights

#### 2. Report Configuration
- Enter report title
- Add optional description
- Select report period (from/to dates)
- Quick buttons for common periods:
  - This Month
  - Last Month
  - This Quarter
  - Last Year

#### 3. View Report
Once generated, reports show:
- **Executive Summary**: AI-generated overview
- **Key Findings**: Main insights and patterns
- **Recommendations**: Actionable suggestions
- **Raw Data**: Complete data table
- **Status**: Generating → Completed → Failed

#### 4. Download Report
- Click **"Download PDF"** button
- PDF contains all analysis and data

#### 5. Manage Reports
- Filter by report type and status
- View generation timestamps
- Check data record count
- Delete archived reports

## API Response Format

The AI service returns responses in this format:

```json
{
  "success": true,
  "analysis": {
    "alert_type": "oil_change",
    "priority": "high",
    "recommendation": "Vehicle has reached 9,500 km since last oil change...",
    "estimated_cost": 150.00,
    "urgency_level": 4
  },
  "raw_response": "Full AI response text"
}
```

## Error Handling

### Common Issues

#### 1. AI Features Not Enabled
**Error**: "AI features are not enabled"
**Solution**: 
- Set `AI_FEATURES_ENABLED=true` in `.env`
- Set valid `OPENAI_API_KEY` in `.env`
- Run `php artisan config:cache`

#### 2. Invalid API Key
**Error**: "Failed to get AI response"
**Solution**:
- Verify API key at https://platform.openai.com/account/api-keys
- Check for spaces or extra characters in `.env`
- Run `php artisan config:cache`

#### 3. Rate Limiting
**Error**: "API rate limit exceeded"
**Solution**:
- Wait before making new requests
- Check OpenAI account plan limits
- Upgrade plan if needed

#### 4. Network Issues
**Error**: "Connection timeout"
**Solution**:
- Check internet connection
- Verify OpenAI API is accessible
- Check firewall settings

## Database Schema

### ai_maintenance_alerts Table
```
- id: Primary Key
- vehicle_id: Foreign Key → vehicles
- created_by: Foreign Key → users
- alert_type: enum(oil_change, tire_replacement, brake_service, battery, filter, transmission, suspension, other)
- priority: enum(low, medium, high, critical)
- status: enum(pending, acknowledged, scheduled, completed, dismissed)
- recommendation: text
- estimated_cost: decimal(10,2)
- urgency_level: integer(1-5)
- ai_analysis: json
- notes: text
- scheduled_date: datetime
- timestamps & soft deletes
```

### ai_reports Table
```
- id: Primary Key
- created_by: Foreign Key → users
- report_type: enum
- title: string
- description: text
- status: enum(generating, completed, failed, archived)
- report_period_from: datetime
- report_period_to: datetime
- filter_criteria: json
- ai_summary: json
- ai_findings: json
- ai_recommendations: json
- ai_analysis: json
- raw_data: json
- error_message: text
- file_path: string
- timestamps & soft deletes
```

## Performance Considerations

### For Large Datasets
1. **Report Generation**: May take several seconds for large time periods
2. **AI Processing**: OpenAI API calls depend on data volume
3. **Caching**: Consider implementing query caching for frequently accessed reports

### Optimization Tips
1. Limit report periods to reasonable ranges (e.g., monthly)
2. Use filters to reduce data volume
3. Archive old reports
4. Monitor OpenAI API usage and costs

## Cost Estimate

OpenAI API Pricing (as of 2024):
- **GPT-3.5 Turbo**: ~$0.0005 per 1K tokens
- **Alert Generation**: ~$0.002-0.005 per alert
- **Report Generation**: ~$0.01-0.05 per report (depending on data size)

**Monitor Usage**:
- Check OpenAI dashboard: https://platform.openai.com/usage
- Set usage limits in OpenAI account settings
- Review costs monthly

## Future Enhancements

Potential additions:
1. **Scheduled Report Generation**: Automated daily/weekly/monthly reports
2. **Advanced Filtering**: Custom filters for report generation
3. **Multiple AI Providers**: Support for other AI services (Anthropic, Gemini)
4. **Predictive Analytics**: ML models for trend analysis
5. **Email Integration**: Automatic report delivery
6. **Webhooks**: Real-time alert notifications
7. **API Endpoints**: For third-party integration
8. **Dashboard Widgets**: Embed reports in main dashboard
9. **Custom Prompts**: User-defined analysis criteria
10. **Export Formats**: Excel, CSV, in addition to PDF

## Troubleshooting

### Check AI Service Status
```php
// In Laravel tinker
php artisan tinker
> $service = new App\Services\AIService();
> $service->isEnabled();
> // Should return true if configured correctly
```

### Test AI Connection
```php
// Generate test alert
$result = $service->generateMaintenanceAlert([
    'registration_number' => 'TST001',
    'make_model' => 'Toyota Camry',
    'age' => 5,
    'mileage' => 50000,
    'last_service' => '2024-03-01',
    'service_interval' => 5000,
]);
```

### Check Database
```php
// Verify tables exist
php artisan tinker
> DB::getSchemaBuilder()->hasTable('ai_maintenance_alerts');
> DB::getSchemaBuilder()->hasTable('ai_reports');
```

## Support

For issues or questions:
1. Check error logs: `storage/logs/laravel.log`
2. Review OpenAI API documentation
3. Test in development environment first
4. Monitor API usage and costs

## License

These AI features are integrated into your VMS System and follow the same license terms.

---

**Installation Date**: April 2, 2026
**Version**: 1.0.0
**Last Updated**: April 2, 2026
