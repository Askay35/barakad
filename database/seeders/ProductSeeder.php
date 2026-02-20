<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // ===== Первые блюда (category_id: 1) =====
            ['name' => 'Борщ', 'description' => 'Наваристый борщ со свёклой, капустой и говядиной. Подаётся со сметаной', 'price' => 220, 'image' => 'https://images.unsplash.com/photo-1603105037880-880cd4f6be00?w=400&h=300&fit=crop', 'category_id' => 1],
            ['name' => 'Щи из свежей капусты', 'description' => 'Традиционные русские щи на мясном бульоне с капустой и картофелем', 'price' => 200, 'image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400&h=300&fit=crop', 'category_id' => 1],
            ['name' => 'Куриный суп с лапшой', 'description' => 'Лёгкий куриный бульон с домашней лапшой, морковью и зеленью', 'price' => 190, 'image' => 'https://images.unsplash.com/photo-1603105037880-880cd4f6be00?w=400&h=300&fit=crop', 'category_id' => 1],
            ['name' => 'Харчо', 'description' => 'Острый грузинский суп с говядиной, рисом и грецкими орехами', 'price' => 260, 'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=400&h=300&fit=crop', 'category_id' => 1],
            ['name' => 'Солянка мясная', 'description' => 'Густая солянка с тремя видами мяса, огурцами и маслинами', 'price' => 280, 'image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400&h=300&fit=crop', 'category_id' => 1],
            ['name' => 'Гороховый суп', 'description' => 'Классический гороховый суп с копчёностями и гренками', 'price' => 210, 'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=400&h=300&fit=crop', 'category_id' => 1],
            ['name' => 'Уха', 'description' => 'Наваристая уха из сёмги с картофелем и зеленью', 'price' => 290, 'image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400&h=300&fit=crop', 'category_id' => 1],

            // ===== Вторые блюда (category_id: 2) =====
            ['name' => 'Плов узбекский', 'description' => 'Рассыпчатый плов с бараниной, морковью, нутом и зирой', 'price' => 320, 'image' => 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Плов с курицей', 'description' => 'Нежный плов с куриным филе, барбарисом и шафраном', 'price' => 280, 'image' => 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Котлета куриная', 'description' => 'Сочная котлета из куриного филе с хрустящей корочкой', 'price' => 180, 'image' => 'https://images.unsplash.com/photo-1632778149955-e80f8ceca2e8?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Котлета говяжья', 'description' => 'Домашняя котлета из отборной говядины со специями', 'price' => 220, 'image' => 'https://images.unsplash.com/photo-1632778149955-e80f8ceca2e8?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Сосиски отварные (2 шт)', 'description' => 'Нежные молочные сосиски, подаются с горчицей', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1612871689353-ccd2e55c8fa0?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Гуляш из говядины', 'description' => 'Томлённая говядина в густом соусе с паприкой и луком', 'price' => 310, 'image' => 'https://images.unsplash.com/photo-1608039829572-04da3895be66?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Бефстроганов', 'description' => 'Нежная говядина в сливочно-грибном соусе', 'price' => 340, 'image' => 'https://images.unsplash.com/photo-1608039829572-04da3895be66?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Тефтели в томатном соусе', 'description' => 'Мясные тефтели с рисом в домашнем томатном соусе (3 шт)', 'price' => 240, 'image' => 'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Шашлык из курицы', 'description' => 'Куриное филе на шампуре с маринованным луком', 'price' => 280, 'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Шашлык из баранины', 'description' => 'Сочный шашлык из молодой баранины с зеленью', 'price' => 380, 'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=300&fit=crop', 'category_id' => 2],
            ['name' => 'Голубцы (2 шт)', 'description' => 'Капустные рулеты с мясной начинкой в сметанном соусе', 'price' => 250, 'image' => 'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=400&h=300&fit=crop', 'category_id' => 2],

            // ===== Гарниры (category_id: 3) =====
            ['name' => 'Гречка', 'description' => 'Рассыпчатая гречневая каша с маслом', 'price' => 80, 'image' => 'https://images.unsplash.com/photo-1536304929831-ee1ca9d44906?w=400&h=300&fit=crop', 'category_id' => 3],
            ['name' => 'Рис отварной', 'description' => 'Белый рис, приготовленный на пару', 'price' => 70, 'image' => 'https://images.unsplash.com/photo-1516684732162-798a0062be99?w=400&h=300&fit=crop', 'category_id' => 3],
            ['name' => 'Картофельное пюре', 'description' => 'Воздушное пюре из картофеля со сливками', 'price' => 90, 'image' => 'https://images.unsplash.com/photo-1585672840563-f2af2ced55c9?w=400&h=300&fit=crop', 'category_id' => 3],
            ['name' => 'Картофель жареный', 'description' => 'Золотистый картофель с луком и укропом', 'price' => 110, 'image' => 'https://images.unsplash.com/photo-1568144628871-cb5622deddfa?w=400&h=300&fit=crop', 'category_id' => 3],
            ['name' => 'Макароны', 'description' => 'Паста из твёрдых сортов пшеницы с маслом', 'price' => 80, 'image' => 'https://images.unsplash.com/photo-1551462147-ff29053bfc14?w=400&h=300&fit=crop', 'category_id' => 3],
            ['name' => 'Овощи на гриле', 'description' => 'Баклажаны, кабачки, перец и помидоры на гриле', 'price' => 170, 'image' => 'https://images.unsplash.com/photo-1506354666786-959d6d497f1a?w=400&h=300&fit=crop', 'category_id' => 3],

            // ===== Салаты (category_id: 4) =====
            ['name' => 'Цезарь с курицей', 'description' => 'Романо, куриная грудка, пармезан, гренки, соус цезарь', 'price' => 320, 'image' => 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?w=400&h=300&fit=crop', 'category_id' => 4],
            ['name' => 'Греческий', 'description' => 'Томаты, огурцы, перец, маслины, фета, оливковое масло', 'price' => 270, 'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=400&h=300&fit=crop', 'category_id' => 4],
            ['name' => 'Оливье', 'description' => 'Классический салат оливье с отварной говядиной', 'price' => 230, 'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=300&fit=crop', 'category_id' => 4],
            ['name' => 'Винегрет', 'description' => 'Свёкла, картофель, морковь, огурцы, горошек', 'price' => 180, 'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=300&fit=crop', 'category_id' => 4],
            ['name' => 'Салат «Витаминный»', 'description' => 'Свежая капуста, морковь, зелень с лимонной заправкой', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=400&h=300&fit=crop', 'category_id' => 4],

            // ===== Выпечка (category_id: 5) =====
            ['name' => 'Хлеб белый', 'description' => 'Свежий пшеничный хлеб, нарезка', 'price' => 30, 'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop', 'category_id' => 5],
            ['name' => 'Хлеб чёрный', 'description' => 'Ржаной хлеб, нарезка', 'price' => 30, 'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop', 'category_id' => 5],
            ['name' => 'Лаваш', 'description' => 'Тонкий армянский лаваш', 'price' => 40, 'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop', 'category_id' => 5],
            ['name' => 'Самса с мясом', 'description' => 'Слоёная самса с сочной начинкой из баранины и лука', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop', 'category_id' => 5],
            ['name' => 'Пирожок с картошкой', 'description' => 'Жареный пирожок с картофельной начинкой', 'price' => 60, 'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop', 'category_id' => 5],

            // ===== Напитки (category_id: 6) =====
            ['name' => 'Тархун', 'description' => 'Домашний лимонад с эстрагоном и лаймом, 500 мл', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1556881286-fc6915169721?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Барбарис', 'description' => 'Освежающий напиток из барбариса с мёдом, 500 мл', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Апельсиновый фреш', 'description' => 'Свежевыжатый апельсиновый сок, 300 мл', 'price' => 200, 'image' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Компот из сухофруктов', 'description' => 'Домашний компот из сушёных яблок, груш и чернослива, 500 мл', 'price' => 90, 'image' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Морс клюквенный', 'description' => 'Ягодный морс из свежей клюквы, 500 мл', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1556881286-fc6915169721?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Чай чёрный', 'description' => 'Крупнолистовой чёрный чай, чайник 400 мл', 'price' => 100, 'image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Чай зелёный', 'description' => 'Китайский зелёный чай, чайник 400 мл', 'price' => 110, 'image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Кофе эспрессо', 'description' => 'Классический эспрессо из свежеобжаренных зёрен', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Кофе латте', 'description' => 'Эспрессо с молочной пенкой, 300 мл', 'price' => 180, 'image' => 'https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?w=400&h=300&fit=crop', 'category_id' => 6],
            ['name' => 'Лимонад домашний', 'description' => 'Лимонад из свежих лимонов с мятой, 500 мл', 'price' => 140, 'image' => 'https://images.unsplash.com/photo-1621263764928-df1444c5e859?w=400&h=300&fit=crop', 'category_id' => 6],

            // ===== Десерты (category_id: 7) =====
            ['name' => 'Медовик', 'description' => 'Классический медовый торт со сметанным кремом', 'price' => 200, 'image' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=400&h=300&fit=crop', 'category_id' => 7],
            ['name' => 'Чак-чак', 'description' => 'Восточная сладость из теста с мёдом', 'price' => 160, 'image' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400&h=300&fit=crop', 'category_id' => 7],
            ['name' => 'Блины со сгущёнкой', 'description' => 'Тонкие блинчики с варёной сгущёнкой (3 шт)', 'price' => 180, 'image' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=300&fit=crop', 'category_id' => 7],
            ['name' => 'Мороженое', 'description' => 'Три шарика: ваниль, шоколад, клубника', 'price' => 170, 'image' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400&h=300&fit=crop', 'category_id' => 7],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
