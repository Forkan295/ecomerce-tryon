<?php

namespace App\Console\Commands;

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class createMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $menu = [
            "title"         => "Catalog",
            "icon"          => "mdi-alpha-c-box",
            "isPermissible" => true,
            "has_child"     => true,
            "permission"    => "product",
            "items"         => [
                [
                    "title"         => "Product",
                    "icon"          => "mdi-circle-small",
                    "isPermissible" => true,
                    "permission"    => "product_index",
                    "route"         => "backend.product.create"
                ],
            ]
        ];

        if (Menu::whereTitle($menu['title'])->exists()) {
            $this->error('Menu already Exist!');
        } else {

            $this->createMenu($menu);
            $this->info('The command was successful!');
        }
    }

    private function createMenu(array $menu)
    {
        DB::beginTransaction();
        try {
            $displayName = str_replace("_", " ", $menu['permission']);
            $permission  = Permission::firstOrCreate([
                'name' => $menu['permission']
            ], [
                'name'         => $menu['permission'],
                'display_name' => $displayName,
                'status'       => true
            ]);

            $newMenu = Menu::create([
                'title'         => $menu['title'],
                'icon'          => $menu['icon'],
                'route'         => data_get($menu, 'route'),
                'permission_id' => $permission->id,
            ]);

            if ($menu['has_child']) {
                foreach ($menu['items'] as $item) {
                    $displayName = str_replace("_", " ", $item['permission']);
                    $childPermission = $permission->children();
                    $hasChild        = $childPermission->whereName($item['permission'])->firstOrFail();
                    if (is_null($hasChild)) {
                        $childPermission = $childPermission->Create([
                            'name' => $item['permission']
                        ], [
                            'name'         => $item['permission'],
                            'display_name' => $displayName,
                            'status'       => true
                        ]);
                    } else {
                        $childPermission = $hasChild;
                    }

                    Menu::create([
                        'title'         => $item['title'],
                        'icon'          => $item['icon'],
                        'route'         => $item['route'],
                        'parent_id'     => $newMenu->id,
                        'permission_id' => $childPermission->id,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
