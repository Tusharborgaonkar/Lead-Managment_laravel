<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lead;
use App\Models\Customer;
use App\Models\Note;
use App\Models\Followup;

echo "=== Testing Lead-First CRM Flow ===\n";

// 1. Create a Lead
echo "\n1. Creating a fresh Lead...\n";
$lead = Lead::create([
    'client_name' => 'John Testing',
    'project_name' => 'SEO Optimization API',
    'email' => 'john.testing@example.com',
    'phone' => '+1234567890',
    'status' => 'Pending',
]);

echo "Created Lead ID: {$lead->id}\n";
echo "Lead Client Name: {$lead->client_name}\n";
echo "Lead Project: {$lead->project_name}\n";
echo "Customer ID (Should be null): " . ($lead->customer_id ?? 'NULL') . "\n";

if ($lead->customer_id !== null) {
    die("FAILED: Lead has a customer_id out of the gate.\n");
}

// 2. Add a Note
echo "\n2. Adding a Note...\n";
$note = $lead->notes()->create([
    'note' => 'Had an initial discovery call. Seems very interested.',
]);
echo "Note created with ID: {$note->id}\n";

// 3. Add a Followup
echo "\n3. Adding a Follow-up...\n";
$followup = $lead->followups()->create([
    'followup_date' => now()->addDays(2)->format('Y-m-d'),
    'followup_time' => '14:30',
    'status' => 'Pending',
]);
echo "Follow-up created for: {$followup->followup_date} {$followup->followup_time}\n";

// 4. Update Lead Status to Won
echo "\n4. Updating Lead Status to Won...\n";
$lead->update(['status' => 'Won']);
echo "Lead Status updated to: {$lead->status}\n";

// 5. Convert Lead to Customer
echo "\n5. Converting Lead to Customer...\n";
// Simulating the Convert logic from LeadController@convert
$customerDetails = [
    'name' => $lead->client_name,
    'email' => $lead->email,
    'phone' => $lead->phone,
    'company_name' => null, // Optional
];

$customer = Customer::where('email', $lead->email)
                    ->orWhere('phone', $lead->phone)
                    ->first();

if (!$customer) {
    echo "No existing customer found. Creating new customer...\n";
    $customer = Customer::create($customerDetails);
} else {
    echo "Found existing customer ID: {$customer->id}\n";
}

$lead->update(['customer_id' => $customer->id]);

echo "Lead linked to Custom ID: {$lead->customer_id}\n";
echo "Customer Name: {$customer->name}\n";

$freshLead = Lead::with('customer')->find($lead->id);

if ($freshLead->customer_id === $customer->id && $freshLead->customer->name === 'John Testing') {
    echo "\n=== ALL TESTS PASSED SUCCESSFULLY ===\n";
} else {
    echo "\n=== TESTS FAILED ===\n";
}

