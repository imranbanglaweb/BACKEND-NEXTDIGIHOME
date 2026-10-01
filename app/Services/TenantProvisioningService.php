<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Location;
use Spatie\Permission\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantProvisioningService
{
    /**
     * Provision a new tenant (company) with all necessary setup
     */
    public function provisionTenant(array $data): Company
    {
        DB::beginTransaction();

        try {
            // 1. Create the company
            $company = $this->createCompany($data);

            // 2. Create default organizational structure
            $this->createDefaultStructure($company);

            // 3. Create admin user for the company
            $adminUser = $this->createCompanyAdmin($company, $data);

            // 4. Create default subscription (trial)
            $this->createTrialSubscription($company, $data);

            // 5. Seed initial data
            $this->seedInitialData($company);

            DB::commit();

            return $company;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create the company record
     */
    private function createCompany(array $data): Company
    {
        return Company::create([
            'company_name' => $data['company_name'],
            'company_code' => $data['company_code'] ?? strtoupper(Str::slug($data['company_name'])),
            'address' => $data['address'] ?? null,
            'contact_number' => $data['contact_number'] ?? null,
            'email' => $data['email'] ?? null,
            'status' => 1,
        ]);
    }

    /**
     * Create default organizational structure
     */
    private function createDefaultStructure(Company $company): void
    {
        // Create default unit
        $unit = $company->units()->create([
            'unit_name' => 'Main Unit',
            'unit_code' => 'MAIN',
            'status' => 1,
        ]);

        // Create default location
        $location = Location::create([
            'company_id' => $company->id,
            'location_name' => 'Head Office',
            'address' => $company->address,
            'status' => 1,
        ]);

        // Create default departments
        $departments = [
            ['name' => 'Administration', 'code' => 'ADMIN'],
            ['name' => 'Human Resources', 'code' => 'HR'],
            ['name' => 'Finance', 'code' => 'FIN'],
            ['name' => 'Operations', 'code' => 'OPS'],
            ['name' => 'IT', 'code' => 'IT'],
            ['name' => 'Transport', 'code' => 'TRANS'],
        ];

        foreach ($departments as $dept) {
            Department::create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'department_name' => $dept['name'],
                'department_code' => $dept['code'],
                'status' => 1,
            ]);
        }
    }

    /**
     * Create company admin user
     */
    private function createCompanyAdmin(Company $company, array $data): User
    {
        // Create admin user
        $admin = User::create([
            'company_id' => $company->id,
            'name' => $data['admin_name'],
            'email' => $data['admin_email'],
            'password' => Hash::make($data['admin_password']),
            'status' => 1,
        ]);

        // Assign admin role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $admin->assignRole($adminRole);
        }

        return $admin;
    }

    /**
     * Create trial subscription
     */
    private function createTrialSubscription(Company $company, array $data): void
    {
        $trialPlan = SubscriptionPlan::where('is_trial', true)->first();

        if (!$trialPlan) {
            // Create default trial plan if not exists
            $trialPlan = SubscriptionPlan::create([
                'name' => 'Trial Plan',
                'slug' => 'trial',
                'price' => 0,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 5,
                'user_limit' => 10,
                'is_trial' => true,
                'trial_days' => 30,
                'features' => ['basic_features'],
                'is_active' => true,
            ]);
        }

        Subscription::create([
            'company_id' => $company->id,
            'plan_id' => $trialPlan->id,
            'start_date' => now(),
            'end_date' => now()->addDays($trialPlan->trial_days ?? 30),
            'status' => 'active',
            'payment_status' => 'trial',
        ]);
    }

    /**
     * Seed initial data for the tenant
     */
    private function seedInitialData(Company $company): void
    {
        // This can be expanded to seed initial vehicle types, maintenance types, etc.
        // For now, just ensure basic structure is in place
    }

    /**
     * Upgrade tenant subscription
     */
    public function upgradeSubscription(Company $company, SubscriptionPlan $newPlan): void
    {
        DB::transaction(function () use ($company, $newPlan) {
            // End current subscription
            $currentSub = $company->subscription;
            if ($currentSub) {
                $currentSub->update(['status' => 'cancelled']);
            }

            // Create new subscription
            Subscription::create([
                'company_id' => $company->id,
                'plan_id' => $newPlan->id,
                'start_date' => now(),
                'end_date' => $newPlan->billing_cycle === 'yearly'
                    ? now()->addYear()
                    : now()->addMonth(),
                'status' => 'active',
                'payment_status' => 'paid',
            ]);
        });
    }

    /**
     * Deactivate tenant
     */
    public function deactivateTenant(Company $company): void
    {
        $company->update(['status' => 0]);

        // Deactivate all users
        $company->users()->update(['status' => 0]);

        // Cancel subscription
        if ($company->subscription) {
            $company->subscription->update(['status' => 'cancelled']);
        }
    }

    /**
     * Reactivate tenant
     */
    public function reactivateTenant(Company $company): void
    {
        $company->update(['status' => 1]);

        // Reactivate admin user
        $admin = $company->users()->whereHas('roles', function ($q) {
            $q->where('name', 'Admin');
        })->first();

        if ($admin) {
            $admin->update(['status' => 1]);
        }
    }
}