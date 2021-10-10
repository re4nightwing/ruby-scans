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
    default:
        http_response_code(404);
        echo @parse_url($_SERVER['REQUEST_URI'])['path'];
        exit('->not found');
}

?>
