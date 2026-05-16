# AI Features Quick Setup Checklist

## Pre-Installation Requirements
- [ ] Laravel 9 or 10 installed
- [ ] PHP 8.0 or higher
- [ ] Database configured and working
- [ ] Composer installed
- [ ] OpenAI account created (https://openai.com)
- [ ] OpenAI API key generated

## Installation Steps

### 1. Install Required Package
```bash
composer require guzzlehttp/guzzle
```
- [ ] Package installed successfully
- [ ] No conflicts with existing packages

### 2. Get OpenAI API Key
- [ ] Go to https://platform.openai.com/api-keys
- [ ] Create new secret key
- [ ] Copy key (save in safe place)
- [ ] Set usage limits if desired

### 3. Configure Environment
Edit `.env` file and add:

```env
OPENAI_API_KEY=sk_your_key_here
OPENAI_MODEL=gpt-3.5-turbo
AI_FEATURES_ENABLED=true
```

- [ ] `.env` file updated with API key
- [ ] API key is valid (no typos)
- [ ] `AI_FEATURES_ENABLED` set to true
- [ ] Model specified (gpt-3.5-turbo recommended)

### 4. Run Migrations
```bash
php artisan migrate
```

- [ ] All 3 AI feature migrations executed
- [ ] Tables created in database:
  - [ ] `ai_maintenance_alerts`
  - [ ] `ai_reports`
- [ ] Menu items added
- [ ] No migration errors

### 5. Clear Cache
```bash
php artisan cache:clear
php artisan config:cache
```

- [ ] Cache cleared
- [ ] Config re-cached
- [ ] No errors during cache clear

### 6. Verify Installation
```php
// Run in Laravel tinker
php artisan tinker
> new App\Services\AIService();
> $service->isEnabled();
// Should return: true
```

- [ ] AIService loads without errors
- [ ] `isEnabled()` returns true
- [ ] No exceptions thrown

## Post-Installation Verification

### 1. Check Database
```bash
php artisan tinker
```

```php
> DB::table('ai_maintenance_alerts')->count();
> DB::table('ai_reports')->count();
> DB::table('menus')->where('name', 'AI Features')->first();
```

- [ ] All tables created and accessible
- [ ] Menu items inserted
- [ ] No SQL errors

### 2. Check Routes
```bash
php artisan route:list | grep ai
```

- [ ] AI Maintenance Alerts routes visible
- [ ] AI Reports routes visible
- [ ] All routes show correct names and methods

### 3. Access Features in Web UI
- [ ] Log in to admin panel
- [ ] Check sidebar for "AI Features" menu
- [ ] Menu items visible:
  - [ ] "Maintenance Alerts (AI)"
  - [ ] "AI Reports"
- [ ] Can navigate to both modules

### 4. Test AI Functionality
1. **Test Maintenance Alert Generation**:
   - [ ] Navigate to Maintenance Alerts
   - [ ] Click "Generate New Alert"
   - [ ] Select a vehicle
   - [ ] Click Generate
   - [ ] Alert created successfully
   - [ ] AI analysis visible
   - [ ] No error messages

2. **Test Report Generation**:
   - [ ] Navigate to AI Reports
   - [ ] Click "Generate New Report"
   - [ ] Select report type (Maintenance Analysis)
   - [ ] Set date range
   - [ ] Click Generate
   - [ ] Report status shows "Generating"
   - [ ] Eventually shows "Completed"
   - [ ] Can view report details

## Common Issues & Fixes

### Issue: "AI features are not enabled"
```
Solution:
1. Check .env file: AI_FEATURES_ENABLED=true
2. Check .env file: OPENAI_API_KEY is set
3. Run: php artisan config:cache
4. Refresh page
```

### Issue: "Invalid API Key"
```
Solution:
1. Verify key at https://platform.openai.com/api-keys
2. Check for spaces/typos in .env
3. Ensure key starts with "sk_"
4. Test with: curl -H "Authorization: Bearer YOUR_KEY" https://api.openai.com/v1/models
```

### Issue: "Class not found: AIService"
```
Solution:
1. Verify file: app/Services/AIService.php exists
2. Run: composer dump-autoload
3. Run: php artisan cache:clear
```

### Issue: "Route not found: ai-maintenance-alerts.index"
```
Solution:
1. Verify routes in routes/web.php
2. Run: php artisan route:cache
3. Run: php artisan route:clear
4. Check for syntax errors in routes file
```

### Issue: "Tables not found in database"
```
Solution:
1. Verify migrations in database/migrations/
2. Run: php artisan migrate:status
3. Run: php artisan migrate
4. Check database connection in .env
```

## Files Verification Checklist

### Controllers
- [ ] `app/Http/Controllers/AIMaintenanceAlertController.php` exists
- [ ] `app/Http/Controllers/AIReportController.php` exists

### Models
- [ ] `app/Models/AIMaintenanceAlert.php` exists
- [ ] `app/Models/AIReport.php` exists

### Services
- [ ] `app/Services/AIService.php` exists

### Migrations
- [ ] `database/migrations/2026_04_02_000001_create_ai_maintenance_alerts_table.php` exists
- [ ] `database/migrations/2026_04_02_000002_create_ai_reports_table.php` exists
- [ ] `database/migrations/2026_04_02_000003_add_ai_features_menu.php` exists

### Views
- [ ] `resources/views/admin/ai-maintenance-alerts/index.blade.php` exists
- [ ] `resources/views/admin/ai-maintenance-alerts/show.blade.php` exists
- [ ] `resources/views/admin/ai-maintenance-alerts/edit.blade.php` exists
- [ ] `resources/views/admin/ai-reports/index.blade.php` exists
- [ ] `resources/views/admin/ai-reports/create.blade.php` exists
- [ ] `resources/views/admin/ai-reports/show.blade.php` exists

### Configuration
- [ ] `config/services.php` updated with OpenAI config

### Routes
- [ ] `routes/web.php` contains AI route imports
- [ ] `routes/web.php` contains AI route definitions

### Documentation
- [ ] `Documentation/AI_FEATURES_GUIDE.md` created
- [ ] This checklist file exists

## Performance Notes

- [ ] Test with at least 10 vehicles before full deployment
- [ ] Monitor OpenAI API usage (check costs)
- [ ] Test with different report types
- [ ] Verify database queries are optimized
- [ ] Check response times (should be < 5 seconds)

## Security Checklist

- [ ] API key not committed to git (in .env)
- [ ] API key rotated if exposed
- [ ] Routes require authentication
- [ ] User permissions properly configured
- [ ] Error messages don't expose sensitive info
- [ ] Rate limiting considered for API calls

## User Training

- [ ] Team trained on Maintenance Alerts usage
- [ ] Team trained on Reports generation
- [ ] Users understand limitations of AI analysis
- [ ] Users know how to interpret results
- [ ] Users understand cost implications

## Final Sign-Off

- [ ] All installation steps completed
- [ ] All verifications passed
- [ ] No outstanding errors or warnings
- [ ] Ready for production deployment

**Installation Completed**: _______________
**Completed By**: _______________
**Date**: _______________

---

For detailed information, see: `Documentation/AI_FEATURES_GUIDE.md`
