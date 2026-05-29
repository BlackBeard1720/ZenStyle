<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Seed 10 stylist co tai khoan dang nhap va ho so nhan vien.
     */
    public function run(): void
    {
        $stylistRole = Role::where('role_name', 'stylist')->firstOrFail();

        $stylists = [
            [
                'username' => 'huyphg',
                'email' => 'huyphg@gmail.com',
                'phone' => '0902000001',
                'password' => 'huy123456',
                'full_name' => 'Huy Phan',
                'specialization' => 'Hair Styling',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780065932/ava5_jysj4l.png',
                'salary' => 12000000,
                'hire_date' => '2025-01-10',
            ],
            [
                'username' => 'emilynguyen',
                'email' => 'emily.nguyen@zenstyle.com',
                'phone' => '0902000002',
                'password' => 'password123',
                'full_name' => 'Emily Nguyen',
                'specialization' => 'Hair Coloring',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066001/ava1_ssubmn.png',
                'salary' => 13000000,
                'hire_date' => '2025-02-15',
            ],
            [
                'username' => 'sophiatran',
                'email' => 'sophia.tran@zenstyle.com',
                'phone' => '0902000003',
                'password' => 'password123',
                'full_name' => 'Sophia Tran',
                'specialization' => 'Spa Treatment',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066021/ava2_npdpdl.png',
                'salary' => 12500000,
                'hire_date' => '2025-03-20',
            ],
            [
                'username' => 'miale',
                'email' => 'mia.le@zenstyle.com',
                'phone' => '0902000004',
                'password' => 'password123',
                'full_name' => 'Mia Le',
                'specialization' => 'Nail Care',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066043/ava3_gcpu6z.png',
                'salary' => 11000000,
                'hire_date' => '2025-04-12',
            ],
            [
                'username' => 'annavo',
                'email' => 'anna.vo@zenstyle.com',
                'phone' => '0902000005',
                'password' => 'password123',
                'full_name' => 'Anna Vo',
                'specialization' => 'Massage Therapy',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066072/ava4_g2ropj.png',
                'salary' => 11500000,
                'hire_date' => '2025-05-08',
            ],
            [
                'username' => 'oliviahoang',
                'email' => 'olivia.hoang@zenstyle.com',
                'phone' => '0902000006',
                'password' => 'password123',
                'full_name' => 'Olivia Hoang',
                'specialization' => 'Hair Treatment',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066109/ava7_ftm2jd.png',
                'salary' => 12800000,
                'hire_date' => '2025-06-01',
            ],
            [
                'username' => 'linhdo',
                'email' => 'linh.do@zenstyle.com',
                'phone' => '0902000007',
                'password' => 'password123',
                'full_name' => 'Linh Do',
                'specialization' => 'Skin Care',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066131/ava8_atuxnp.png',
                'salary' => 11800000,
                'hire_date' => '2025-06-20',
            ],
            [
                'username' => 'jessicavu',
                'email' => 'jessica.vu@zenstyle.com',
                'phone' => '0902000008',
                'password' => 'password123',
                    'full_name' => 'Jessica Vu',
                'specialization' => 'Makeup & Beauty',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066153/ava9_bbmgeg.png',
                'salary' => 12200000,
                'hire_date' => '2025-07-05',
            ],
            [
                'username' => 'noahtran',
                'email' => 'noah.tran@zenstyle.com',
                'phone' => '0902000009',
                'password' => 'password123',
                'full_name' => 'Noah Tran',
                'specialization' => 'Men Haircut',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066212/ava6_abcbaq.png',
                'salary' => 11900000,
                'hire_date' => '2025-07-18',
            ],
            [
                'username' => 'kellypham',
                'email' => 'kelly.pham@zenstyle.com',
                'phone' => '0902000010',
                'password' => 'password123',
                'full_name' => 'Kelly Pham',
                'specialization' => 'Relaxing Shampoo',
                'avatar' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780066177/ava10_gmg6ry.png',
                'salary' => 11200000,
                'hire_date' => '2025-08-02',
            ],
        ];

        foreach ($stylists as $stylist) {
            $user = User::updateOrCreate(
                ['email' => $stylist['email']],
                [
                    'username' => $stylist['username'],
                    'phone' => $stylist['phone'],
                    'password' => Hash::make($stylist['password']),
                    'role_id' => $stylistRole->id,
                    'status' => 'active',
                ]
            );

            Staff::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $stylist['full_name'],
                    'phone' => $stylist['phone'],
                    'email' => $stylist['email'],
                    'specialization' => $stylist['specialization'],
                    'avatar' => $stylist['avatar'],
                    'salary' => $stylist['salary'],
                    'hire_date' => $stylist['hire_date'],
                    'status' => 'active',
                ]
            );
        }
    }
}
