<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\Note;
use App\Models\Followup;
use App\Models\Customer;
use Carbon\Carbon;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        // 1. A pending lead with no customer yet
        $lead1 = Lead::create([
            'client_name' => 'Alice Johnson',
            'phone' => '+1 555-0100',
            'email' => 'alice@startup.io',
            'project_name' => 'Mobile App Development',
            'status' => 'Pending',
        ]);

        Note::create([
            'lead_id' => $lead1->id,
            'note' => 'Initial inquiry received from website contact form.',
        ]);

        Followup::create([
            'lead_id' => $lead1->id,
            'followup_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'followup_time' => '10:00:00',
            'status' => 'Pending',
        ]);

        // 2. A Won lead linked to a Customer
        $customer = Customer::first();
        
        $lead2 = Lead::create([
            'client_name' => $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'project_name' => 'ERP System Integration',
            'status' => 'Confirm',
            'customer_id' => $customer->id,
        ]);

        Note::create([
            'lead_id' => $lead2->id,
            'note' => 'Deal closed successfully. Starting integration phase next week.',
        ]);

        Followup::create([
            'lead_id' => $lead2->id,
            'followup_date' => Carbon::now()->subDays(1)->format('Y-m-d'), // Overdue for testing
            'followup_time' => '14:00:00',
            'status' => 'Pending',
        ]);
        
        // 3. A Lost lead
        $lead3 = Lead::create([
            'client_name' => 'Bob Williams',
            'phone' => '+1 555-0200',
            'email' => 'bob@competitor.com',
            'project_name' => 'Marketing Website',
            'status' => 'Not Interested',
        ]);

        Note::create([
            'lead_id' => $lead3->id,
            'note' => 'Project went to a competitor due to budget constraints.',
        ]);
    }
}
