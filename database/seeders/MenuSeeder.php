<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Services\MenuService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultMenu = [
            [
                "title"         => "Product",
                "icon"          => "mdi-alpha-p-box",
                "isPermissible" => true,
                "has_child"     => false,
                "permission"    => "product_index",
                "route"         => "backend.product.index"
            ],
            [
                "title"         => "Category",
                "icon"          => "mdi-alpha-c-box",
                "isPermissible" => true,
                "has_child"     => false,
                "permission"    => "category_index",
                "route"         => "backend.categories.index"
            ],
            [
                "title"         => "Attribute",
                "icon"          => "mdi-alpha-a-box",
                "isPermissible" => true,
                "has_child"     => false,
                "permission"    => "attribute_index",
                "route"         => "backend.attributes.index"
            ],
            [
                "title"         => "Tag",
                "icon"          => "mdi-tag-multiple",
                "isPermissible" => false,
                "has_child"     => false,
                "permission"    => "tags_index",
                "route"         => "backend.tags.index"
            ],
            [
                "title"         => "Tax",
                "icon"          => "mdi-percent-box",
                "isPermissible" => true,
                "has_child"     => false,
                "permission"    => "taxes_index",
                "route"         => "backend.taxes.index"
            ],
            [
                "title"         => "Settings",
                "icon"          => "mdi-cog",
                "isPermissible" => true,
                "has_child"     => true,
                "permission"    => "settings",
                "items"         => [
                    [
                        "title"         => "Store Details",
                        "icon"          => "mdi-circle-small",
                        "isPermissible" => true,
                        "permission"    => "settings_store",
                        "route"         => "backend.store-details.index"
                    ],
                    [
                        "title"         => "General",
                        "icon"          => "mdi-circle-small",
                        "isPermissible" => true,
                        "permission"    => "settings_general",
                        "route"         => "backend.settings.form"
                    ],
                    [
                        "title"         => "Gateways",
                        "icon"          => "mdi-circle-small",
                        "isPermissible" => true,
                        "permission"    => "settings_gateways",
                        "route"         => "backend.groups.index"
                    ],
                    [
                        "title"         => "Shipping",
                        "icon"          => "mdi-circle-small",
                        "isPermissible" => true,
                        "permission"    => "settings_shipping",
                        "route"         => "backend.groups.index"
                    ]
                ]
            ],
            [
                "title"         => "Clients",
                "icon"          => "mdi-account-group",
                "isPermissible" => true,
                "has_child"     => true,
                "permission"    => "client",
                "items"         => [
                    [
                        "title"         => "Client List",
                        "icon"          => "mdi-circle-small",
                        "isPermissible" => true,
                        "permission"    => "client_index",
                        "route"         => "backend.users.index"
                    ],
                    [
                        "title"         => "Roles",
                        "icon"          => "mdi-circle-small",
                        "isPermissible" => true,
                        "permission"    => "client_roles_index",
                        "route"         => "backend.role.index"
                    ],
                    [
                        "title"         => "Permissions",
                        "icon"          => "mdi-circle-small",
                        "isPermissible" => true,
                        "permission"    => "client_permissions_index",
                        "route"         => "backend.permission.index"
                    ],
                ]
            ],
            [
                "title"         => "Admin",
                "icon"          => "mdi-account-circle",
                "isPermissible" => true,
                "has_child"     => true,
                "permission"    => "admin",
                "items"         => [
                    [
                        "title"         => "Admin List",
                        "icon"          => "mdi-circle-small",
                        "isPermissible" => true,
                        "permission"    => "admin_index",
                        "route"         => "admin.admins.index"
                    ]
                ]
            ]
        ];
        foreach ($defaultMenu as $menu) {
            $displayName = str_replace("_", " ", $menu['permission']);
            $permission  = Permission::create([
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
                    $displayName     = str_replace("_", " ", $item['permission']);
                    $childPermission = $permission->children()->create([
                        'name'         => $item['permission'],
                        'display_name' => $displayName,
                        'status'       => true
                    ]);

                    $newChildMenu = Menu::create([
                        'title'         => $item['title'],
                        'icon'          => $item['icon'],
                        'route'         => $item['route'],
                        'parent_id'     => $newMenu->id,
                        'permission_id' => $childPermission->id,
                    ]);
                }
            }
        }
    }
}
