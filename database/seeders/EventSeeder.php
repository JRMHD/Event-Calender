<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user with ID 2 or create one if none exists
        $user = User::find(2);
        if (!$user) {
            $user = User::factory()->create([
                'id' => 2,
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // September 2025 Events (9 events)
        $septemberEvents = [
            [
                'title' => 'Nairobi Tech Conference 2025',
                'description' => 'Annual technology conference bringing together Kenya\'s top innovators, entrepreneurs, and tech enthusiasts at KICC.',
                'start_date' => '2025-09-05',
                'end_date' => '2025-09-06',
                'start_time' => '09:00',
                'end_time' => '17:00',
                'all_day' => false,
                'color' => '#4285F4',
                'priority' => 'high',
                'location' => 'Kenyatta International Convention Centre, Nairobi',
                'status' => 'active',
            ],
            [
                'title' => 'Maasai Mara Wildlife Photography Workshop',
                'description' => 'Professional wildlife photography workshop in the world-famous Maasai Mara National Reserve.',
                'start_date' => '2025-09-12',
                'end_date' => '2025-09-15',
                'start_time' => null,
                'end_time' => null,
                'all_day' => true,
                'color' => '#34A853',
                'priority' => 'medium',
                'location' => 'Maasai Mara National Reserve',
                'status' => 'active',
            ],
            [
                'title' => 'Kenya Coffee Board Cupping Session',
                'description' => 'Learn about Kenya\'s premium coffee varieties and cupping techniques from certified Q-graders.',
                'start_date' => '2025-09-18',
                'end_date' => '2025-09-18',
                'start_time' => '14:00',
                'end_time' => '16:30',
                'all_day' => false,
                'color' => '#FBBC04',
                'priority' => 'medium',
                'location' => 'Kenya Coffee Board, Nairobi',
                'status' => 'active',
            ],
            [
                'title' => 'Lamu Cultural Festival Planning Meeting',
                'description' => 'Coordination meeting for the upcoming Lamu Cultural Festival with local organizers and stakeholders.',
                'start_date' => '2025-09-03',
                'end_date' => '2025-09-03',
                'start_time' => '10:00',
                'end_time' => '12:00',
                'all_day' => false,
                'color' => '#EA4335',
                'priority' => 'high',
                'location' => 'Lamu Island Cultural Centre',
                'status' => 'active',
            ],
            [
                'title' => 'Mount Kenya Hiking Expedition',
                'description' => 'Guided hiking expedition to Point Lenana, Mount Kenya\'s third highest peak.',
                'start_date' => '2025-09-20',
                'end_date' => '2025-09-23',
                'start_time' => '06:00',
                'end_time' => '18:00',
                'all_day' => false,
                'color' => '#34A853',
                'priority' => 'high',
                'location' => 'Mount Kenya National Park',
                'status' => 'active',
            ],
            [
                'title' => 'Kenya Agricultural Show Visit',
                'description' => 'Annual visit to Kenya\'s premier agricultural exhibition showcasing farming innovations and livestock.',
                'start_date' => '2025-09-27',
                'end_date' => '2025-09-27',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'all_day' => false,
                'color' => '#FBBC04',
                'priority' => 'medium',
                'location' => 'Jamhuri Showground, Nairobi',
                'status' => 'active',
            ],
            [
                'title' => 'Samburu Traditional Dance Workshop',
                'description' => 'Learn traditional Samburu dances and cultural practices from community elders.',
                'start_date' => '2025-09-14',
                'end_date' => '2025-09-14',
                'start_time' => '15:00',
                'end_time' => '18:00',
                'all_day' => false,
                'color' => '#9C27B0',
                'priority' => 'low',
                'location' => 'Samburu Cultural Center, Maralal',
                'status' => 'active',
            ],
            [
                'title' => 'Lake Nakuru Flamingo Watching',
                'description' => 'Early morning flamingo and wildlife watching at the beautiful Lake Nakuru National Park.',
                'start_date' => '2025-09-08',
                'end_date' => '2025-09-08',
                'start_time' => '06:30',
                'end_time' => '11:00',
                'all_day' => false,
                'color' => '#FF9800',
                'priority' => 'medium',
                'location' => 'Lake Nakuru National Park',
                'status' => 'active',
            ],
            [
                'title' => 'Kenyan Independence Day Celebration',
                'description' => 'Attend the national celebrations marking Kenya\'s independence at Uhuru Gardens.',
                'start_date' => '2025-09-12',
                'end_date' => '2025-09-12',
                'start_time' => null,
                'end_time' => null,
                'all_day' => true,
                'color' => '#EA4335',
                'priority' => 'high',
                'location' => 'Uhuru Gardens, Nairobi',
                'status' => 'active',
            ],
        ];

        // October 2025 Events (12 events)
        $octoberEvents = [
            [
                'title' => 'Tusker Safari Rally Spectating',
                'description' => 'Watch Kenya\'s legendary Safari Rally stages and experience world-class motorsport action.',
                'start_date' => '2025-10-03',
                'end_date' => '2025-10-05',
                'start_time' => '08:00',
                'end_time' => '17:00',
                'all_day' => false,
                'color' => '#FF5722',
                'priority' => 'high',
                'location' => 'Various locations, Central Kenya',
                'status' => 'active',
            ],
            [
                'title' => 'Mombasa Dhow Sunset Cruise',
                'description' => 'Traditional dhow sailing experience along Mombasa\'s historic coastline at sunset.',
                'start_date' => '2025-10-12',
                'end_date' => '2025-10-12',
                'start_time' => '17:30',
                'end_time' => '19:30',
                'all_day' => false,
                'color' => '#00BCD4',
                'priority' => 'medium',
                'location' => 'Old Port, Mombasa',
                'status' => 'active',
            ],
            [
                'title' => 'Kenyan Startup Pitch Competition',
                'description' => 'Annual startup competition featuring Kenya\'s most innovative tech entrepreneurs and investors.',
                'start_date' => '2025-10-18',
                'end_date' => '2025-10-18',
                'start_time' => '13:00',
                'end_time' => '18:00',
                'all_day' => false,
                'color' => '#4285F4',
                'priority' => 'high',
                'location' => 'iHub, Nairobi',
                'status' => 'active',
            ],
            [
                'title' => 'Amboseli Elephant Research Project',
                'description' => 'Participate in elephant behavior research and conservation efforts in Amboseli.',
                'start_date' => '2025-10-07',
                'end_date' => '2025-10-10',
                'start_time' => null,
                'end_time' => null,
                'all_day' => true,
                'color' => '#795548',
                'priority' => 'medium',
                'location' => 'Amboseli National Park',
                'status' => 'active',
            ],
            [
                'title' => 'Kisumu Fish Market Cultural Tour',
                'description' => 'Explore the vibrant Kisumu fish market and learn about Lake Victoria\'s fishing industry.',
                'start_date' => '2025-10-22',
                'end_date' => '2025-10-22',
                'start_time' => '07:00',
                'end_time' => '10:00',
                'all_day' => false,
                'color' => '#607D8B',
                'priority' => 'low',
                'location' => 'Kisumu Fish Market, Kisumu',
                'status' => 'active',
            ],
            [
                'title' => 'Kenyan Fashion Week Attendance',
                'description' => 'Attend Kenya\'s premier fashion event showcasing local designers and African fashion trends.',
                'start_date' => '2025-10-25',
                'end_date' => '2025-10-27',
                'start_time' => '18:00',
                'end_time' => '22:00',
                'all_day' => false,
                'color' => '#E91E63',
                'priority' => 'medium',
                'location' => 'Sarit Centre, Nairobi',
                'status' => 'active',
            ],
            [
                'title' => 'Traditional Kikuyu Cooking Class',
                'description' => 'Learn to prepare traditional Kikuyu dishes including mukimo, githeri, and nyama choma.',
                'start_date' => '2025-10-15',
                'end_date' => '2025-10-15',
                'start_time' => '11:00',
                'end_time' => '15:00',
                'all_day' => false,
                'color' => '#FBBC04',
                'priority' => 'low',
                'location' => 'Kiambu Cultural Centre',
                'status' => 'active',
            ],
            [
                'title' => 'Hell\'s Gate National Park Cycling',
                'description' => 'Cycling adventure through Hell\'s Gate National Park with wildlife viewing and rock climbing.',
                'start_date' => '2025-10-29',
                'end_date' => '2025-10-29',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'all_day' => false,
                'color' => '#34A853',
                'priority' => 'medium',
                'location' => 'Hell\'s Gate National Park, Naivasha',
                'status' => 'active',
            ],
            [
                'title' => 'Nairobi National Museum History Tour',
                'description' => 'Comprehensive tour of Kenya\'s national museum covering natural history, culture, and archaeology.',
                'start_date' => '2025-10-05',
                'end_date' => '2025-10-05',
                'start_time' => '10:00',
                'end_time' => '13:00',
                'all_day' => false,
                'color' => '#9C27B0',
                'priority' => 'low',
                'location' => 'Nairobi National Museum',
                'status' => 'active',
            ],
            [
                'title' => 'Rift Valley Observatory Stargazing',
                'description' => 'Evening stargazing session in the clear skies of the Rift Valley with professional telescopes.',
                'start_date' => '2025-10-19',
                'end_date' => '2025-10-19',
                'start_time' => '19:00',
                'end_time' => '23:00',
                'all_day' => false,
                'color' => '#3F51B5',
                'priority' => 'medium',
                'location' => 'Menengai Crater, Nakuru',
                'status' => 'active',
            ],
            [
                'title' => 'Machakos Hills Hiking & Picnic',
                'description' => 'Family-friendly hiking trip to Machakos Hills followed by a traditional Kenyan picnic.',
                'start_date' => '2025-10-11',
                'end_date' => '2025-10-11',
                'start_time' => '09:00',
                'end_time' => '15:00',
                'all_day' => false,
                'color' => '#8BC34A',
                'priority' => 'low',
                'location' => 'Machakos Hills, Machakos County',
                'status' => 'active',
            ],
            [
                'title' => 'Kenya Film Festival Screening',
                'description' => 'Attend screenings of the best Kenyan and African films at the annual Kenya Film Festival.',
                'start_date' => '2025-10-31',
                'end_date' => '2025-10-31',
                'start_time' => '19:00',
                'end_time' => '22:00',
                'all_day' => false,
                'color' => '#FF9800',
                'priority' => 'medium',
                'location' => 'Kenya National Theatre, Nairobi',
                'status' => 'active',
            ],
        ];

        // Create September events
        foreach ($septemberEvents as $eventData) {
            Event::create(array_merge($eventData, ['user_id' => $user->id]));
        }

        // Create October events
        foreach ($octoberEvents as $eventData) {
            Event::create(array_merge($eventData, ['user_id' => $user->id]));
        }

        $this->command->info('Successfully seeded ' . count($septemberEvents) . ' September events and ' . count($octoberEvents) . ' October events!');
    }
}
