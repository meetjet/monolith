<?php

return [
    /**
     * Main menu.
     */
    'main' => [
        [
            'title' => "Dashboard",
            'route' => "dashboard", // "route" or "url"
            'icon' => "ri-home-2-line",
            'roles' => "",
        ],
        [
            'title' => "Users",
            'route' => "users.index",
            'icon' => "ri-user-line",
            'roles' => "root|admin",
            'children' => [
                [
                    'title' => "Create user",
                    'url' => "users/create",
                    'icon' => "",
                    'roles' => "admin",
                ],
            ]
        ],
        [
            'title' => "Pages",
            'url' => "pages",
            'icon' => "ri-pages-line",
            'roles' => "",
        ],
    ],
    /**
     * Bottom menu.
     */
//    'bottom' => [
//        [
//            'title' => "Bottom 1",
//            'url' => "bottom1",
//            'icon' => "ri-article-line",
//            'roles' => "",
//        ],
//        [
//            'title' => "Bottom 2",
//            'url' => "bottom2",
//            'icon' => "ri-article-line",
//            'roles' => "",
//        ],
//    ],
];
