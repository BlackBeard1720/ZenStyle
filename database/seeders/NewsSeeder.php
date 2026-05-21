<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Cach chon kieu toc phu hop voi khuon mat',
                'summary' => 'Mot kieu toc dep nen bat dau tu ti le khuon mat, chat toc va thoi quen cham soc hang ngay.',
                'image' => '/images/frontend/hottrend/hottrend-06.png',
                'body' => [
                    'Truoc khi cat toc, stylist thuong quan sat khuon mat, tran, xuong ham va do day cua toc de de xuat form phu hop. Kieu toc dung se giup tong the gon hon thay vi chi chay theo xu huong.',
                    'Neu khuon mat tron, ban co the uu tien phan mai co do phong va hai ben gon vua phai. Neu khuon mat dai, nen can bang bang do dai phan dinh dau va tranh tao qua nhieu chieu cao.',
                    'Dieu quan trong la kieu toc phai hop voi lich sinh hoat. Mot form toc can 20 phut moi ngay de tao kieu se khong phu hop voi nguoi thich su nhanh gon.',
                ],
            ],
            [
                'title' => 'Nhung dau hieu cho thay toc can treatment phuc hoi',
                'summary' => 'Toc kho, roi, mat do bong hoac de dut gay la luc ban nen nghi den phuc hoi chuyen sau.',
                'image' => '/images/frontend/services/featured-spa.png',
                'body' => [
                    'Sau nhieu lan uon, nhuom hoac dung nhiet, lop bieu bi cua soi toc co the bi mo ra lam toc mat nuoc va thieu do bong. Luc nay dau xa thong thuong chi giup mem tam thoi.',
                    'Treatment phuc hoi giup bo sung duong chat, lam be mat toc muot hon va giam tinh trang roi khi chai. Hieu qua se ro hon neu ket hop voi cach goi va say dung.',
                    'Neu toc da yeu, ban nen tam dung tay/nhuom manh va dat lich tu van de stylist danh gia muc do hu ton truoc khi lam dich vu moi.',
                ],
            ],
            [
                'title' => 'Goi dau duong sinh khac gi voi goi dau thong thuong',
                'summary' => 'Goi duong sinh khong chi lam sach toc ma con tap trung vao massage da dau, co vai gay va cam giac thu gian.',
                'image' => '/images/frontend/services/featured-goi.png',
                'body' => [
                    'Goi dau thong thuong tap trung lam sach bui ban va dau thua. Goi duong sinh co them cac dong tac massage theo nhip cham de giam cang vung da dau, co va vai.',
                    'Dich vu nay phu hop voi nguoi thuong doi mu bao hiem, lam viec voi may tinh hoac cam thay nang dau sau mot ngay dai.',
                    'De buoi goi thoai mai hon, ban nen bao truoc neu da dau nhay cam, khong thich luc massage manh hoac dang co vung dau bi dau.',
                ],
            ],
            [
                'title' => 'Luu y truoc khi nhuom toc lan dau',
                'summary' => 'Nhuom toc lan dau nen bat dau bang tu van nen toc, muc do sang mong muon va kha nang cham soc sau dich vu.',
                'image' => '/images/frontend/banner/Gemini_Generated_Image_7sr4oq7sr4oq7sr4.png',
                'body' => [
                    'Mau toc tren anh tham khao co the khac voi ket qua thuc te vi phu thuoc vao nen toc hien tai. Toc den tu nhien, toc da nhuom den va toc da tay se cho ket qua khac nhau.',
                    'Neu ban moi nhuom lan dau, cac tone nau, nau lanh hoac mau tram de cham soc hon cac mau sang can tay manh.',
                    'Sau khi nhuom, nen dung dau goi giu mau, han che nuoc qua nong va dat lich duong toc dinh ky neu toc co dau hieu kho.',
                ],
            ],
            [
                'title' => 'Bao lau nen cat lai form toc',
                'summary' => 'Thoi diem cat lai tuy vao toc moc nhanh hay cham, nhung da so form toc gon can duoc chinh sau 3 den 6 tuan.',
                'image' => '/images/frontend/services/featured-toc.png',
                'body' => [
                    'Voi cac kieu toc ngan, phan vien va hai ben se mat form nhanh hon phan dinh dau. Sau khoang 3 den 4 tuan, tong the co the bat dau kem gon.',
                    'Voi toc layer, mullet hoac toc dai hon, ban co the chinh form sau 5 den 8 tuan de giu do roi va ti le.',
                    'Neu dang nuoi toc, cat lai khong co nghia la cat ngan. Stylist co the tia phan hu ton va giu khung dang de toc moc dep hon.',
                ],
            ],
            [
                'title' => 'Cach giu nep toc sau khi uon texture',
                'summary' => 'Uon texture dep hon khi ban biet cach goi, say va dung san pham tao kieu nhe moi ngay.',
                'image' => '/images/frontend/banner/Gemini_Generated_Image_7w6kln7w6kln7w6k.png',
                'body' => [
                    'Trong 24 den 48 gio dau sau uon, nen han che goi dau de nep toc on dinh hon. Sau do, hay dung dau goi diu nhe va xa duong vua du.',
                    'Khi say, dung tay nang chan toc va bop nhe theo huong texture. Khong nen chai manh khi toc con uot vi de lam roi nep.',
                    'Mot luong nho sap hoac cream tao kieu se giup toc vao form ma khong bi nang. Neu toc kho, uu tien san pham co do duong nhe.',
                ],
            ],
            [
                'title' => 'Cham soc da co ban cho nguoi moi bat dau',
                'summary' => 'Lam sach, duong am va chong nang la ba buoc nen on dinh truoc khi them nhieu san pham treatment.',
                'image' => '/images/frontend/banner/Gemini_Generated_Image_kt0965kt0965kt09.png',
                'body' => [
                    'Mot chu trinh cham soc da co ban khong can qua phuc tap. Lam sach dung cach giup giam dau thua va bui ban sau mot ngay dai.',
                    'Duong am giup da can bang hon, ke ca voi da dau. Khi da thieu am, be mat da co the tiet dau nhieu hon.',
                    'Ban ngay, chong nang la buoc quan trong de bao ve da va giu hieu qua cua cac dich vu cham soc da tai salon.',
                ],
            ],
            [
                'title' => 'Vao salon can noi gi voi stylist',
                'summary' => 'Noi ro mong muon, lich su hoa chat va thoi quen tao kieu giup stylist dua ra tu van chinh xac hon.',
                'image' => '/images/frontend/hottrend/hottrend-03.png',
                'body' => [
                    'Anh tham khao rat huu ich, nhung ban cung nen noi diem minh thich trong anh: do dai, mau sac, do phong hay cam giac tong the.',
                    'Lich su uon, nhuom, tay va phuc hoi trong vai thang gan day la thong tin quan trong. No giup stylist tranh xu ly qua suc chiu cua toc.',
                    'Hay noi thang ve thoi gian ban co the danh cho viec tao kieu moi ngay. Mot kieu toc dep tai salon van can phu hop khi ban tu cham soc o nha.',
                ],
            ],
            [
                'title' => 'Dat lich cuoi tuan nen chuan bi nhu the nao',
                'summary' => 'Dat lich som, den dung gio va chon dich vu phu hop giup buoi hen cuoi tuan nhe nhang hon.',
                'image' => '/images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png',
                'body' => [
                    'Cuoi tuan thuong la thoi diem salon dong khach. Dat lich truoc giup ban co khung gio dep va co them thoi gian tu van neu lam dich vu dai.',
                    'Neu ban lam mau, uon hoac combo thu gian, nen de trong lich them mot khoang dem vi thoi gian co the thay doi theo tinh trang toc.',
                    'Mang theo anh tham khao va ghi chu cac dieu minh khong thich se giup buoi tu van nhanh va dung trong tam hon.',
                ],
            ],
            [
                'title' => 'Nhung thoi quen nho giup toc khoe hon',
                'summary' => 'Goi dung tan suat, han che nhiet cao va cat tia phan hu ton la nen tang cho mai toc khoe.',
                'image' => '/images/frontend/banner/Gemini_Generated_Image_ympfunympfunympf.png',
                'body' => [
                    'Khong phai ai cung can goi dau moi ngay. Tan suat phu hop phu thuoc vao da dau, moi truong lam viec va san pham tao kieu dang dung.',
                    'Nhiet cao tu may say, kep va uon co the lam toc kho nhanh hon. Neu can tao kieu bang nhiet, nen dung muc nhiet vua va san pham bao ve toc.',
                    'Cat tia dinh ky giup loai bo phan ngon toc xau, nhat la voi toc dai, toc nhuom hoac toc da qua xu ly hoa chat.',
                ],
            ],
        ];

        foreach ($posts as $index => $post) {
            $slug = Str::slug($post['title']);

            News::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $post['title'],
                    'summary' => $post['summary'],
                    'body' => collect($post['body'])->map(fn ($paragraph) => '<p>' . e($paragraph) . '</p>')->implode(''),
                    'image' => $post['image'],
                    'status' => 'active',
                    'created_at' => now()->subDays($index),
                    'updated_at' => now()->subDays($index),
                ]
            );
        }
    }
}
