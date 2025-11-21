<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhimTheLoaiSeeder extends Seeder
{
    public function run()
    {
        DB::table('phim_the_loais')->truncate();

        DB::table('phim_the_loais')->insert([
            // 1. Avengers Endgame
            ['id_phim' => 1, 'id_the_loai' => 1], // Hành động
            ['id_phim' => 1, 'id_the_loai' => 5], // Viễn tưởng

            // 2. Titanic
            ['id_phim' => 2, 'id_the_loai' => 2], // Tình cảm

            // 3. Avatar 2
            ['id_phim' => 3, 'id_the_loai' => 4], // Phiêu lưu -> Kinh dị? Không hợp → chuyển thành Hành động + Viễn tưởng
            ['id_phim' => 3, 'id_the_loai' => 5],

            // 4. John Wick 4
            ['id_phim' => 4, 'id_the_loai' => 1],

            // 5. The Dark Knight
            ['id_phim' => 5, 'id_the_loai' => 1],

            // 6. Spider-Man NWH
            ['id_phim' => 6, 'id_the_loai' => 1],
            ['id_phim' => 6, 'id_the_loai' => 5],

            // 7. Interstellar
            ['id_phim' => 7, 'id_the_loai' => 5],

            // 8. Joker
            ['id_phim' => 8, 'id_the_loai' => 6],
            ['id_phim' => 8, 'id_the_loai' => 1],

            // 9. Fast & Furious 9
            ['id_phim' => 9, 'id_the_loai' => 1],

            // 10. Hacksaw Ridge
            ['id_phim' => 10, 'id_the_loai' => 1],

            // 11. Inception
            ['id_phim' => 11, 'id_the_loai' => 5],

            // 12. Frozen 2
            ['id_phim' => 12, 'id_the_loai' => 6],

            // 13. Black Panther
            ['id_phim' => 13, 'id_the_loai' => 1],
            ['id_phim' => 13, 'id_the_loai' => 5],

            // 14. The Batman
            ['id_phim' => 14, 'id_the_loai' => 1],

            // 15. Venom 2
            ['id_phim' => 15, 'id_the_loai' => 1],
            ['id_phim' => 15, 'id_the_loai' => 5],

            // 16. Doctor Strange 2
            ['id_phim' => 16, 'id_the_loai' => 5],

            // 17. GOTG 3
            ['id_phim' => 17, 'id_the_loai' => 5],

            // 18. Deadpool 2
            ['id_phim' => 18, 'id_the_loai' => 3], // Hài

            // 19. Lion King
            ['id_phim' => 19, 'id_the_loai' => 6],

            // 20. Dune
            ['id_phim' => 20, 'id_the_loai' => 5],

            // === Phim 21–40 ===

            ['id_phim' => 21, 'id_the_loai' => 1],
            ['id_phim' => 22, 'id_the_loai' => 1],
            ['id_phim' => 22, 'id_the_loai' => 5],

            ['id_phim' => 23, 'id_the_loai' => 1],
            ['id_phim' => 23, 'id_the_loai' => 5],

            ['id_phim' => 24, 'id_the_loai' => 1],

            ['id_phim' => 25, 'id_the_loai' => 3], // Barbie = Hài

            ['id_phim' => 26, 'id_the_loai' => 1],
            ['id_phim' => 26, 'id_the_loai' => 5],

            ['id_phim' => 27, 'id_the_loai' => 5],

            ['id_phim' => 28, 'id_the_loai' => 5],
            ['id_phim' => 28, 'id_the_loai' => 1],

            ['id_phim' => 29, 'id_the_loai' => 5],

            ['id_phim' => 30, 'id_the_loai' => 1],

            ['id_phim' => 31, 'id_the_loai' => 3], // Hài

            ['id_phim' => 32, 'id_the_loai' => 5],

            ['id_phim' => 33, 'id_the_loai' => 1],

            ['id_phim' => 34, 'id_the_loai' => 1],

            ['id_phim' => 35, 'id_the_loai' => 3], // Hài

            ['id_phim' => 36, 'id_the_loai' => 1],

            ['id_phim' => 37, 'id_the_loai' => 4], // Kinh dị

            ['id_phim' => 38, 'id_the_loai' => 4], // Kinh dị

            ['id_phim' => 39, 'id_the_loai' => 1],

            ['id_phim' => 40, 'id_the_loai' => 1],
        ]);
    }
}
