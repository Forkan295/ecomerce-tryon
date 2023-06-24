<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    protected ?Authenticatable $user;
    protected Collection $menus;

    public function __construct()
    {
        $this->user  = auth()->user();
        $this->menus = Menu::with(['parent', 'children', 'permission'])->where('parent_id', 0)->get();
    }

    public function getMenus(): Collection|array
    {
        return $this->generateMenu();
    }

    private function generateMenu(): Collection|array
    {
        // when Application boot user won't be found
        if (is_null($this->user)) {
            return [];
        }

        return $this->menus->transform(function ($item) {
            $data['title']         = data_get($item, 'title');
            $data['icon']          = data_get($item, 'icon');
            $data['isPermissible'] = $this->checkPermissible(data_get($item, 'permission.name'));
            $data['has_child']     = false;
            $data['permission']    = $item->permission->name;

            if (!is_null($item->route)) {
                $data['route'] = $item->route;
            }

            if (count($item->children) > 0) {
                $data['has_child'] = true;
                $data['items']     = $item->children->transform(function ($child) {
                    return [
                        'title'         => $child->title,
                        'icon'          => $child->icon,
                        'isPermissible' => $this->checkPermissible($child->permission->name),
                        'has_child'     => false,
                        'permission'    => $child->permission->name,
                        'route'         => $child->route,
                    ];
                });
            }

            return $data;
        });
    }

    private function checkPermissible($name): bool
    {
        return !is_null($name) ? $this->user->hasPermission($name) : false;
    }

}
