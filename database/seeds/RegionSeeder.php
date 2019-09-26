<?php
namespace  JoyBusinessAcademy\Profile\Seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::transaction(function(){
                Schema::disableForeignKeyConstraints();

                DB::table(config('jba-profile.table_names.regions'))->truncate();

                if(config('database.default') == 'sqlite') {
                    DB::insert('insert into sqlite_sequence (name, seq) values (?, ?)', [config('jba-profile.table_names.regions'), 1]);
                }
                else {
                    DB::statement('ALTER TABLE ' . config('jba-profile.table_names.regions') . ' AUTO_INCREMENT = 1');
                }
                foreach(self::regionSource() as $id => $top) {

                    $class = config('jba-profile.models.region');

                    $region = $class::create([
                        'id' => ($id + 1),
                        'name' => $top['name']
                    ]);

                    foreach($top['children'] as $cId => $sub) {
                        $class::create([
                            'id' => ($region->id * 100 + $cId),
                            'parent_id' => $region->id,
                            'name' => $sub['name']
                        ]);
                    }
                }

                Schema::enableForeignKeyConstraints();
            });
        }
        catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function regionSource()
    {
        return [
            [
                'name' => 'Northland',
                'children' => [
                    [
                        'name' => 'Far North'
                    ],
                    [
                        'name' => 'Kaipara'
                    ],
                    [
                        'name' => 'Whangarei'
                    ]
                ]
            ],

            [
                'name' => 'Auckland',
                'children' => [
                    [
                        'name' => 'Auckland City'
                    ],
                    [
                        'name' => 'Franklin'
                    ],
                    [
                        'name' => 'Hauraki Golf Islands'
                    ],
                    [
                        'name' => 'Manukau'
                    ],
                    [
                        'name' => 'North Shore'
                    ],
                    [
                        'name' => 'Papakura'
                    ],
                    [
                        'name' => 'Rodney'
                    ],
                    [
                        'name' => 'Waiheke Island'
                    ],
                    [
                        'name' => 'Waitakere'
                    ]
                ]
            ],

            [
                'name' => 'Waikato',
                'children' => [
                    [
                        'name' => 'Hamilton'
                    ],
                    [
                        'name' => 'Hauraki'
                    ],
                    [
                        'name' => 'Matamata'
                    ],
                    [
                        'name' => 'Otorohanga'
                    ],
                    [
                        'name' => 'South Waikato'
                    ],
                    [
                        'name' => 'Waikato'
                    ]
                ]
            ],

            [
                'name' => 'Bay of Plenty',
                'children' => [
                    [
                        'name' => 'Taupo'
                    ],
                    [
                        'name' => 'Thames – Coromandel'
                    ],
                    [
                        'name' => 'Kawerau'
                    ],
                    [
                        'name' => 'Opotiki'
                    ],
                    [
                        'name' => 'Rotorua'
                    ],
                    [
                        'name' => 'Tauranga'
                    ],
                    [
                        'name' => 'Western Bay of Plenty'
                    ],
                    [
                        'name' => 'Whakatane'
                    ]
                ]
            ],

            [
                'name' => 'Taranaki',
                'children' => [
                    [
                        'name' => 'Waipa'
                    ],
                    [
                        'name' => 'Waitomo'
                    ],
                    [
                        'name' => 'New Plymouth'
                    ],
                    [
                        'name' => 'South Taranaki'
                    ],
                    [
                        'name' => 'Stratford'
                    ],
                    [
                        'name' => 'Ruapehu'
                    ],
                    [
                        'name' => 'Tararua'
                    ],
                    [
                        'name' => 'Whanganui'
                    ]
                ]
            ],

            [
                'name' => 'East Coast',
                'children' => [
                    [
                        'name' => 'Gisborne'
                    ],
                    [
                        'name' => 'Central Hawkes Bay'
                    ],
                    [
                        'name' => 'Hastings'
                    ],
                    [
                        'name' => 'Napier'
                    ],
                    [
                        'name' => 'Wairoa'
                    ]
                ]
            ],

            [
                'name' => 'Central',
                'children' => [
                    [
                        'name' => 'Horowhenua'
                    ],
                    [
                        'name' => 'Manawatu'
                    ],
                    [
                        'name' => 'Palmerston North'
                    ],
                    [
                        'name' => 'Rangitikei'
                    ],
                    [
                        'name' => 'Caterton'
                    ],
                    [
                        'name' => 'Kapiti Coast'
                    ]
                ]
            ],

            [
                'name' => 'Wellington',
                'children' => [
                    [
                        'name' => 'Lower Hutt'
                    ],
                    [
                        'name' => 'Masterton'
                    ],
                    [
                        'name' => 'Porirua'
                    ],
                    [
                        'name' => 'South Wairarapa'
                    ],
                    [
                        'name' => 'Upper Hutt'
                    ],
                    [
                        'name' => 'Wellington City'
                    ],
                    [
                        'name' => 'Wellington'
                    ]
                ]
            ],

            [
                'name' => 'Nelson',
                'children' => [
                    [
                        'name' => 'Tasman'
                    ],
                    [
                        'name' => 'Nelson'
                    ],
                    [
                        'name' => 'Blenheim'
                    ],
                    [
                        'name' => 'Kaikoura'
                    ],
                    [
                        'name' => 'Marlborough'
                    ],
                    [
                        'name' => 'Buller'
                    ],
                    [
                        'name' => 'Greymouth'
                    ],
                    [
                        'name' => 'Westland'
                    ]
                ]
            ],

            [
                'name' => 'Canterbury',
                'children' => [
                    [
                        'name' => 'Ashburton'
                    ],
                    [
                        'name' => 'Banks Peninsula'
                    ],
                    [
                        'name' => 'Christchurch City'
                    ],
                    [
                        'name' => 'Hurunui'
                    ],
                    [
                        'name' => 'Mackenzie'
                    ],
                    [
                        'name' => 'Selwyn'
                    ],
                    [
                        'name' => 'Waimakariri'
                    ],
                    [
                        'name' => 'Waimate'
                    ]
                ]
            ],

            [
                'name' => 'Southern',
                'children' => [
                    [
                        'name' => 'Timaru'
                    ],
                    [
                        'name' => 'Central Otago'
                    ],
                    [
                        'name' => 'Clutha'
                    ],
                    [
                        'name' => 'Dunedin'
                    ],
                    [
                        'name' => 'Queenstown'
                    ],
                    [
                        'name' => 'South Otago'
                    ],
                    [
                        'name' => 'Waitaki'
                    ],
                    [
                        'name' => 'Wanaka'
                    ],
                    [
                        'name' => 'Catlins'
                    ],
                    [
                        'name' => 'Gore'
                    ],
                    [
                        'name' => 'Invercargill'
                    ],
                    [
                        'name' => 'Southland'
                    ],
                    [
                        'name' => 'Te Anau'
                    ]
                ]
            ],
        ];
    }
}

