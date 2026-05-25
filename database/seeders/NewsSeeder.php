<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        News::insert(
            [
                [
                    'title' => "These Are Vietnam's Best Hotels, Pools, Spas and More in 2025",
                    'summary' => 'A curated guide to the most relaxing and trusted spa and wellness places in Hanoi for customers who want premium beauty services.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716082/luxury-awards-2025_vietnam-intercontinental-danang-1024x672-1_kenpz3.jpg',
                    'external_url' => 'https://www.travelandleisureasia.com/th/hotels/luxuryawards/these-are-vietnam-best-hotels-pools-spas-and-more-in-2025/',
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'title' => 'How to Choose the Right Bangs for Your Face Shape',
                    'summary' => 'A simple guide to choosing hairstyles based on face shape, hair texture, and daily styling habits.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716148/6dd24801b7d49551ffd77772d4889bd25be61d7e-1000x667_btyj4j.png',
                    'external_url' => 'https://www.newbeauty.com/view/bangs-for-your-face-shape',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(1),
                    'updated_at' => $now->copy()->subDays(1),
                ],
                [
                    'title' => 'Dry Hair: Symptoms, Causes, and Treatments',
                    'summary' => 'Dryness, frizz, dullness, and breakage are common signs that your hair may need deeper recovery care.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716183/recommended_radiancebeauty_1_zpqys7.webp',
                    'external_url' => 'https://www.webmd.com/beauty/dry-hair-causes',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(2),
                    'updated_at' => $now->copy()->subDays(2),
                ],
                [
                    'title' => 'Can Scalp Massagers Help With Hair Growth? Experts Explain',
                    'summary' => 'Discover how herbal head washes and scalp massages focus not only on cleansing but also on relaxation and stress relief.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716270/250311-scalp-massager-vl-main-317cfb_cnn1ew.avif',
                    'external_url' => 'https://www.today.com/shop/scalp-massagers-hair-growth-rcna195829',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(3),
                    'updated_at' => $now->copy()->subDays(3),
                ],
                [
                    'title' => 'How Do I Know What Hair Color Suits Me Based on My Skin Tone',
                    'summary' => 'our natural hair color and skin color are the same tone. Put simply, warm skin tones look best with warm hair colors and cool skin tones look best with cool hair colors.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716309/Clairol_Retail-Natural_Instincts_Bold-TOOLKIT_FY23_12_07_22_Day1_002_Trio_-image_ikvjwy.jpg',
                    'external_url' => 'https://www.clairol.com/en-US/blog/hair-coloring/choosing-a-hair-color-to-complement-your-skin-tone',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(4),
                    'updated_at' => $now->copy()->subDays(4),
                ],
                [
                    'title' => '15 Easy Hairstyles for Short Hair',
                    'summary' => 'Looking for a quick styling routine? Check out these beautiful and practical short hairstyles for everyday wear.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716363/Screen-Shot-2016-07-14-at-20732-PM-24967684-cbc3-460e-99ba-6895e5e98625_qrtdmn.jpg',
                    'external_url' => 'https://www.romper.com/p/15-easy-hairstyles-for-short-hair-14342',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(5),
                    'updated_at' => $now->copy()->subDays(5),
                ],
                [
                    'title' => 'How to Care for Fine Hair, According to Stylists',
                    'summary' => 'Professional advice on restoring shine and strength to chemically treated or heat-damaged hair.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716416/dry-damaged-hair-realsimple-GettyImages-483149491-961e71178a344142a9afa0682122108b_stpah2.webp',
                    'external_url' => 'https://www.realsimple.com/beauty-fashion/hair/hair-care/fine-hair-care',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(6),
                    'updated_at' => $now->copy()->subDays(6),
                ],
                [
                    'title' => 'Is Rosemary Oil Really Effective for Hair Growth or Just Hype? Experts Weigh In',
                    'summary' => 'Learn which essential oils can help improve scalp health and promote thicker, healthier hair growth.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716454/a5db100c-49a0-488d-af83-3732268c6b6d.jpeg_kzwctm.jpg',
                    'external_url' => 'https://www.elle.com/beauty/hair/a38603963/rosemary-oil-for-hair/',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(7),
                    'updated_at' => $now->copy()->subDays(7),
                ],
                [
                    'title' => 'What Is Balayage? Everything You Need to Know',
                    'summary' => 'The complete guide to the popular balayage highlighting technique, maintenance, and why salons love it.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716489/Blog_5_w5m7iu.webp',
                    'external_url' => 'https://www.kellieandcompany.com/blog/what-is-balayage-everything-you-need-to-know/',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(8),
                    'updated_at' => $now->copy()->subDays(8),
                ],
                [
                    'title' => '10 Home Remedies for Dandruff and Itchy Scalp That Work',
                    'summary' => 'Combat flaky scalps with these natural treatments, perfectly paired with a professional head spa routine.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716609/10_Home_Remedies_for_Dandruff_and_Itchy_Scalp_That_Work_rdq2vi.png',
                    'external_url' => 'https://www.fortishealthcare.com/blogs/10-home-remedies-dandruff-and-itchy-scalp-work',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(9),
                    'updated_at' => $now->copy()->subDays(9),
                ],
                [
                    'title' => 'Japanese Head Spas: A Viral Trend Living Up To The Hype',
                    'summary' => 'Discover why intense scalp cleansing and massage treatments are becoming the top requested service in salons globally.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716641/Headspa2-1158x1536_noqivf.jpg',
                    'external_url' => 'https://unwind.com.au/japanese-head-spas-a-viral-trend-living-up-to-the-hype/',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(10),
                    'updated_at' => $now->copy()->subDays(10),
                ],
                [
                    'title' => '11 Best Hair Masks to Make Strands Smoother and Stronger in Minutes',
                    'summary' => 'Deep conditioning treatments and masks that will instantly revive dull locks and protect them from future damage.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716680/Allure_BestofBeauty_Clean07_i7xydy.jpg',
                    'external_url' => 'https://www.allure.com/gallery/best-hair-masks-for-damaged-hair',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(11),
                    'updated_at' => $now->copy()->subDays(11),
                ],
                [
                    'title' => 'How Often Should You Wash Your Hair?',
                    'summary' => 'Experts break down the optimal hair-washing schedule based on your hair type, lifestyle, and scalp conditions.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716914/washing-long-hair-182177857_refij2.jpg',
                    'external_url' => 'https://health.clevelandclinic.org/the-dirty-truth-about-washing-your-hair',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(12),
                    'updated_at' => $now->copy()->subDays(12),
                ],
                [
                    'title' => 'Pros and Cons of Keratin Treatments',
                    'summary' => 'Everything you need to consider before booking a smoothing keratin treatment at your local hair salon.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716970/keratin-treatment-732x549-thumbnail-732x549_mk2pbw.jpg',
                    'external_url' => 'https://www.healthline.com/health/keratin-treatment-pros-and-cons',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(13),
                    'updated_at' => $now->copy()->subDays(13),
                ],
                [
                    'title' => 'All about hair porosity and why it matters',
                    'summary' => 'Understanding how well your hair absorbs and retains moisture can completely change your haircare routine.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779716996/Hair_porosity-1_1400x_kdwxw1.jpg',
                    'external_url' => 'https://www.luxyhair.com/blogs/hair-blog/hair-porosity?srsltid=AfmBOopjD2-hA5xF1382ymwiCtoaMIY7Ds_d2mLA997THdRBoPeVYg69',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(14),
                    'updated_at' => $now->copy()->subDays(14),
                ],
                [
                    'title' => 'Silk Pillowcases: Are They Worth It?',
                    'summary' => 'How sleeping on silk can reduce hair breakage, minimize frizz, and extend the life of your salon blowout.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779717023/Silk-Pillowcase-0345_y9stwu.jpg',
                    'external_url' => 'https://livinginyellow.com/2020/03/silk-pillowcases-are-they-worth-it.html',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(15),
                    'updated_at' => $now->copy()->subDays(15),
                ],
                [
                    'title' => 'Beautiful, Healthy Hair: Top 14 Foods for Hair Growth',
                    'summary' => 'A balanced diet rich in specific vitamins and minerals can promote stronger, healthier hair from the inside out.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779717045/z5546121833383_91a03f169f5e8eca84e538e5af365342_41894269e87b4116a9d54f22f7651d3c_1024x1024_gaichw.jpg',
                    'external_url' => 'https://heebeevietnam.vn/blogs/green-living/beautiful-healthy-hair-top-14-foods-for-hair-growth',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(16),
                    'updated_at' => $now->copy()->subDays(16),
                ],
                [
                    'title' => 'How to Protect Your Hair From Sun Damage',
                    'summary' => 'UV rays can cause color fading and dry out your strands. Here are the best ways to protect your hair in the summer.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779717066/applying-hair-oil-protection-2198580555_zfecta.jpg',
                    'external_url' => 'https://health.clevelandclinic.org/best-ways-to-protect-your-hair-from-sun-damage',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(17),
                    'updated_at' => $now->copy()->subDays(17),
                ],
                [
                    'title' => 'These Haircuts Are Going To Be Huge For Spring 2026',
                    'summary' => 'From textured bobs to curtain bangs, explore the most requested salon haircuts dominating the trends right now.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779717087/hair-summer-3bcbbb12b7ae465d9f8ae7423234c6d5_aop1uf.webp',
                    'external_url' => 'https://www.southernliving.com/fashion-beauty/hairstyles/popular-hairstyles',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(18),
                    'updated_at' => $now->copy()->subDays(18),
                ],
                [
                    'title' => 'Why You Need a Heat Protectant Spray',
                    'summary' => 'If you use blow dryers, straighteners, or curling irons, a heat protectant is the non-negotiable step in your routine.',
                    'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779717106/gettyimages-1215552570-681cf6da3adb8.jpg_fsvcsh.jpg',
                    'external_url' => 'https://www.womenshealthmag.com/beauty/a64643659/benefits-of-heat-protectants-for-hair/',
                    'status' => 'active',
                    'created_at' => $now->copy()->subDays(19),
                    'updated_at' => $now->copy()->subDays(19),
                ]
            ]
        );
    }
}
