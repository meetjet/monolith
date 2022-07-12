<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class MenusManagerService
{
    private array $menus = [];

    /**
     * @return array
     */
    public function all(): array
    {
        $menuMap = collect(config("menu-map"));

        $menuMap->each(function ($items, $name) {
            // TODO: add styles
            $menu = $this->makeMenu($items);
            $menu->addClass("mt-2");
            $menu->applyToAll(function (Link $link) {
                $link->addClass("text-sm text-gray-200 ml-3")->addParentClass("rounded-sm py-2");
            });

            $this->menus[$name] = $menu->render();
        });

        return $this->menus;
    }

    /**
     * @param array $items
     *
     * @return Menu
     */
    private function makeMenu(array $items): Menu
    {
        $menu = Menu::new();

        foreach ($items as $_item) {
            if ($this->isValidItem($_item)) {
                if (isset($_item['route'])) {
                    $link = Link::toRoute($_item['route'], __($_item['title']))
                        ->setParentAttribute('icon', $_item['icon']);
                } else {
                    $link = Link::to($_item['url'], __($_item['title']))
                        ->setParentAttribute('icon', $_item['icon']);
                }

                $menu->addIf($this->hasAccess($_item['roles']), $link);

                if (isset($_item['children'])) {
                    $subMenu = $this->makeMenu($_item['children']);
                    $menu->addIf($this->hasAccess($_item['roles']), $subMenu);
                }
            }
        }

        $menu->setActiveFromRequest();

        return $menu;
    }

    /**
     * @param array $item
     *
     * @return bool
     */
    #[Pure] private function isValidItem(array $item): bool
    {
        $result = true;

        if (!isset($item['title'], $item['roles'], $item['icon'])) {
            $result = false;
        }

        if (!isset($item['route']) && !isset($item['url'])) {
            $result = false;
        }

        if (isset($item['children']) && !is_array($item['children'])) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    private function hasAccess(string $role): bool
    {
        if (empty($role)) {
            return true;
        }

        $authGuard = Auth::guard();

        /** @var User $user */
        $user = $authGuard->user();

        if ($user) {
            $roles = explode("|", $role);
            foreach ($roles as $_role) {
                if ($user->hasRole($_role)) {
                    return true;
                }
            }
        }

        return false;
    }
}
