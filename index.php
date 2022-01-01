<?php
ini_set('allow_url_fopen',1);
switch(@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'home.php';
        break;
    case '/index':
        require 'home.php';
        break;
    case '/index.php':
        require 'home.php';
        break;
    case '/admin.php':
        require 'admin.php';
        break;
    case '/admin-logout.php':
        require 'admin-logout.php';
        break;
    case '/admin-dashboard.php':
        require 'admin-dashboard.php';
        break;
    case '/admin-edit-magazine.php':
        require 'admin-edit-magazine.php';
        break;
    case '/admin-show-magazines.php':
        require 'admin-show-magazines.php';
        break;
    case '/admin-show-chapters.php':
        require 'admin-show-chapters.php';
        break;
    case '/admin-edit-chapter.php':
        require 'admin-edit-chapter.php';
        break;
    case '/magazine-details':
        require 'magazine-details.php';
        break;
    case '/magazine-details.php':
        require 'magazine-details.php';
        break;
    case '/view-chapter':
        require 'view-chapter.php';
        break;
    case '/view-chapter.php':
        require 'view-chapter.php';
        break;
    case '/validate.php':
        require 'validate.php';
        break;
    case '/user-logout.php':
        require 'user-logout.php';
        break;
    case '/get-rubies.php':
        require 'get-rubies.php';
        break;
    case '/toss-coin-game.php':
        require 'toss-coin-game.php';
        break;
    case '/blackjack-game.php':
        require 'blackjack-game.php';
        break;
    case '/notify-rubies.php':
        require 'notify-rubies.php';
        break;
    case '/add-item.php':
        require 'add-item.php';
        break;
    case '/user-profile.php':
        require 'user-profile.php';
        break;
    case '/search-manga.php':
        require 'search-manga.php';
        break;
    case '/load-item.php':
        require 'load-item.php';
        break;
    case '/about-us.php':
        require 'about-us.php';
        break;
    case '/admin-show-messages.php':
        require 'admin-show-messages.php';
        break;
    case '/admin-show-users.php':
        require 'admin-show-users.php';
        break;
    case '/admin-edit-user.php':
        require 'admin-edit-user.php';
        break;
    case '/categories.php':
        require 'categories.php';
        break;
    default:
        http_response_code(404);
        require 'not_found.php';
        //echo @parse_url($_SERVER['REQUEST_URI'])['path'];
        exit();
}

?>
