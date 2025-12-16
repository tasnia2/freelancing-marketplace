<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MarketplaceJob;
use App\Models\JobProposal;
use App\Models\Contract;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@worknest.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample clients
        $clients = User::factory(5)->create([
            'role' => 'client',
            'company' => 'Business Co.',
            'location' => 'Dhaka, Bangladesh',
        ]);

        // Create sample freelancers
        $freelancers = User::factory(10)->create([
            'role' => 'freelancer',
            'title' => 'Web Developer',
            'hourly_rate' => rand(15, 50),
            'location' => 'Remote',
            'bio' => 'Experienced web developer specializing in Laravel and Vue.js',
        ]);

        // Create profiles for freelancers
        foreach ($freelancers as $freelancer) {
            Profile::create([
                'user_id' => $freelancer->id,
                'headline' => 'Senior Web Developer',
                'description' => 'I build amazing web applications using modern technologies.',
                'skills' => json_encode(['Laravel', 'PHP', 'Vue.js', 'JavaScript', 'MySQL', 'Tailwind CSS']),
                'website' => 'https://portfolio.dev',
                'linkedin' => 'https://linkedin.com/in/username',
                'github' => 'https://github.com/username',
            ]);
        }

        // Create sample jobs
        foreach ($clients as $client) {
            $jobs = MarketplaceJob::factory(3)->create([
                'client_id' => $client->id,
            ]);

            // Create proposals for jobs
            foreach ($jobs as $job) {
                foreach ($freelancers->random(3) as $freelancer) {
                    JobProposal::create([
                        'job_id' => $job->id,
                        'freelancer_id' => $freelancer->id,
                        'cover_letter' => 'I am interested in working on this project. I have relevant experience and can deliver quality work on time.',
                        'bid_amount' => $job->budget ? $job->budget * 0.8 : rand(100, 1000),
                        'estimated_days' => rand(7, 30),
                        'status' => rand(0, 1) ? 'pending' : 'accepted',
                    ]);
                }

                // Create contracts for accepted proposals
                $acceptedProposal = $job->proposals()->where('status', 'accepted')->first();
                if ($acceptedProposal) {
                    Contract::create([
                        'job_id' => $job->id,
                        'client_id' => $client->id,
                        'freelancer_id' => $acceptedProposal->freelancer_id,
                        'amount' => $acceptedProposal->bid_amount,
                        'title' => $job->title,
                        'description' => $job->description,
                        'status' => 'active',
                        'start_date' => now(),
                        'end_date' => now()->addDays($acceptedProposal->estimated_days),
                    ]);
                }
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@worknest.com / password');
        $this->command->info('Client: client1@example.com / password');
        $this->command->info('Freelancer: freelancer1@example.com / password');
    }
}