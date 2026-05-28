<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        // Tat kiem tra khoa ngoai de truncate khong bi loi
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('comments')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Lay danh sach service dang co trong database
        $services = Service::query()->select('id', 'name')->get();

        // Neu chua co service thi khong seed comment
        if ($services->isEmpty()) {
            return;
        }

        $commentsByService = [
            [
                'name' => 'Linh Nguyen',
                'comment' => 'The service was very relaxing and the staff were friendly.',
                'status' => 'approved',
            ],
            [
                'name' => 'Minh Anh',
                'comment' => 'Good experience. I will come back next time.',
                'status' => 'approved',
            ],
            [
                'name' => 'Hoang Tran',
                'comment' => 'Clean space, professional staff and reasonable price.',
                'status' => 'approved',
            ],
            [
                'name' => 'Mai Pham',
                'comment' => 'I really like the result. Highly recommended.',
                'status' => 'pending',
            ],
            [
                'name' => 'Thanh Nguyen',
                'comment' => 'Nice service, but I hope the waiting time can be shorter.',
                'status' => 'hidden',
            ],
        ];

        $data = [];

        foreach ($services as $service) {
            foreach ($commentsByService as $item) {
                $data[] = [
                    'service_id' => $service->id,
                    'name' => $item['name'],
                    'comment' => $item['comment'],
                    'status' => $item['status'],
                    'created_at' => Carbon::now()->subDays(rand(1, 20)),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('comments')->insert($data);
    }
}
