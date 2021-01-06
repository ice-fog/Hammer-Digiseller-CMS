<?php

error_reporting(0);

define('APP', true);

include $_SERVER['DOCUMENT_ROOT'] . '/modules/Admin.php';

function __autoload($class) {
    require $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class . '.php';
}

Registry::set('db-config', '/config/db-config.php');
Registry::set('templates-dir', '/admin/public/templates/');
Registry::set('templates-ext', '.tpl');
Registry::set('cache-dir', '/cache/xml/');

$admin = new Admin();
$routes = $admin->getRoute();
$user = $admin->getUser();
$limit = 30;

if(!$user) {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'], $_POST['password'])) {
        if($admin->login($_POST['login'], $_POST['password'])) {
            header("Location: /admin");
            exit();
        } else {
            header("Location: /admin?fail=yes");
            exit();
        }
    } else {
        echo $admin->getTemplate()->compileBloc('login', null);
    }
    return;
}

switch($routes[2]) {
    case '':
        header("Location: /admin/statistics");
        break;
    case 'pages':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'enable':
                                if($admin->getPages()->multipleUpdateStatus($_POST['id'], 1)) {
                                    echo 'ok';
                                }
                                break;
                            case 'disable':
                                if($admin->getPages()->multipleUpdateStatus($_POST['id'], 0)) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getPages()->multipleDeletePage($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'get-form-add':
                    echo $admin->getTemplate()->compileBloc('forms/add/page', null);
                    break;
                case 'get-form-edit':
                    if(is_numeric($_POST['id'])) {
                        echo $admin->getTemplate()->compileBloc('forms/edit/page', $admin->getPageEditData($_POST['id']));
                    }
                    break;
                case 'get-form-sys-edit':
                    if(is_string($_POST['page'])) {
                        echo $admin->getTemplate()->compileBloc('forms/edit/sys-page', $admin->getSysPageEditData($_POST['page']));
                    }
                    break;
                case 'update-status':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['status'])) {
                        if($admin->getPages()->updateStatus($_POST['id'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'sys-edit':
                    if(isset($_POST['page'], $_POST['content'])) {
                        if($admin->getSysPages()->updatePage($_POST['page'], htmlspecialchars($_POST['content']))) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'check-free-url':
                    $id = $admin->getPages()->checkFreeURL($_POST['url']);
                    echo !$id ? "ok" : $id;
                    break;
                case 'edit':
                    if(isset($_POST['id'], $_POST['url'], $_POST['title'], $_POST['status'], $_POST['content'], $_POST['description'])) {
                        if($admin->getPages()->editPage($_POST['id'], $_POST['url'], $_POST['status'], $_POST['title'], $_POST['description'], $_POST['content'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'add':
                    if(isset($_POST['url'], $_POST['title'], $_POST['status'], $_POST['content'], $_POST['description'])) {
                        if($admin->getPages()->addPage($_POST['url'], $_POST['status'], $_POST['title'], $_POST['description'], $_POST['content'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getPages()->deletePage($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        } else {
            if($routes[3] == 'system') {
                $out = $admin->managementSysPages();
            } else {
                $out = $admin->managementPages();
            }

        }
        break;
    case 'service':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'get-cache-size':
                    echo json_encode(array(
                        'section' => fileSizeConvert(getDirSize($admin->getRootDir().Registry::get('cache-dir').'section')),
                        'seller' => fileSizeConvert(getDirSize($admin->getRootDir().Registry::get('cache-dir').'seller')),
                        'goods' => fileSizeConvert(getDirSize($admin->getRootDir().Registry::get('cache-dir').'goods')),
                        'total' => fileSizeConvert(getDirSize($admin->getRootDir().Registry::get('cache-dir')))
                    ));
                    break;
                case 'cache-clear':
                    if(is_numeric($_POST['type'])){
                        $admin->getContent()->clearCache($_POST['type']);
                        echo 'ok';
                    }
                    break;
            }
        } else {
            $out = $admin->managementService();
        }
        break;
    case 'feedback':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'archive':
                                if($admin->getFeedback()->multipleArchive($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getFeedback()->multipleDelete($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getFeedback()->delete($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'archive':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getFeedback()->archive($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        } elseif($routes['3'] == 'archive') {
            $out = $admin->managementFeedback(true);
        } else {
            $out = $admin->managementFeedback();
        }
        break;
    case 'delivery':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'enable':
                                if($admin->getEmailDelivery()->multipleUpdateStatus($_POST['id'], 1)) {
                                    echo 'ok';
                                }
                                break;
                            case 'disable':
                                if($admin->getEmailDelivery()->multipleUpdateStatus($_POST['id'], 0)) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getEmailDelivery()->multipleDelete($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'update-status':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['status'])) {
                        if($admin->getEmailDelivery()->updateStatus($_POST['id'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'get-form-new':
                    echo $admin->getTemplate()->compileBloc('forms/add/delivery', null);
                    break;
                case 'new':
                    if(isset($_POST['name'], $_POST['content'])) {
                        if($admin->getEmailDelivery()->newDelivery($_POST['name'], $_POST['content'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getEmailDelivery()->delete($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        } else {
            if($routes[3] == 'inactive') {
                $page = is_numeric($routes[4]) ? $routes[4] : 1;
                $out = $admin->managementDelivery($limit, $page, 'inactive');
            } else {
                $page = is_numeric($routes[3]) ? $routes[3] : 1;
                $out = $admin->managementDelivery($limit, $page);
            }
        }
        break;
    case 'statistics':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'get-stat':
                    echo json_encode(array_reverse($admin->getStat(10)));
                    break;
                case 'get-log':
                    echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/log');
                    break;
            }
        } else {
            $out = $admin->managementStatistics();
        }
        break;
    case 'editor':
        if($routes[3] == 'get') {
            if(isset($_POST['dir'])) {
                echo $admin->getFileEditor()->getFileList($_POST['dir']);
            }
        } elseif($routes[3] == 'load') {
            echo $admin->getFileEditor()->getFileContent($_POST['file']);
        } elseif($routes[3] == 'save') {
            if(isset($_POST['file'], $_POST['content'])) {
                if($admin->getFileEditor()->saveFile($_POST['file'], $_POST['content'])) {
                    echo 'ok';
                }
            }
        } else {
            $out = $admin->managementEditor();
        }
        break;

    case 'settings':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'update':
                    if(isset($_POST['email'], $_POST['site-title'], $_POST['records-page'], $_POST['site-description'])) {
                        $settings = array();
                        $settings['email'] = $_POST['email'];
                        $settings['currency'] = $_POST['currency'];
                        $settings['home-seller'] = $_POST['home-seller'];
                        $settings['xml-id'] = $_POST['xml-id'];
                        $settings['order'] = $_POST['order'];
                        $settings['ad-block-seller'] = $_POST['ad-block-seller'];
                        $settings['agent-id'] = $_POST['agent-id'];
                        $settings['site-title'] = $_POST['site-title'];
                        $settings['rss-enable'] = intval($_POST['rss-enable']);
                        $settings['sitemap-enable'] = intval($_POST['sitemap-enable']);
                        $settings['ad-block-enable'] = intval($_POST['ad-block-enable']);
                        $settings['notifications-enable'] = $_POST['notifications-enable'];
                        $settings['records-page'] = intval($_POST['records-page']);
                        $settings['site-description'] = $_POST['site-description'];
                        $settings['robots-enable'] = intval($_POST['robots-enable']);
                        $settings['robots-content'] = $_POST['robots-content'];
                        if($admin->getSettings()->updateSettings($settings)) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'get-map-location':
                    echo $admin->getSettings()->settings['map-location'];
                    break;
            }
        } else {
            $out = $admin->managementSettings();
        }

        break;
    case 'users':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'get-form-edit':
                    if(isset($_POST['id'])) {
                        echo $admin->getTemplate()->compileBloc('forms/edit/user', $admin->getUserEditData($_POST['id']));
                    }
                    break;
                case 'edit':
                    if(isset($_POST['id'], $_POST['login'], $_POST['old-password'])) {
                        if($user['password'] !== md5(md5($_POST['old-password']))) {
                            echo 'wrong-password';
                        } else {
                            if(strlen($_POST['new-password']) > 0) {
                                $admin->getDb()->query("UPDATE users SET login = ?s, password = ?s WHERE id = ?i", $_POST['login'], md5(md5($_POST['new-password'])), 1);
                                echo 'ok';
                            } else {
                                $admin->getDb()->query("UPDATE users SET login = ?s WHERE id = ?i", $_POST['login'], 1);
                                echo 'ok';
                            }
                        }
                    }
                    break;
            }
        }
        break;
    case 'images':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'add':
                    echo json_encode($admin->getImages()->upload());
                    break;
            }
        }
        break;
    case 'logout':
        $admin->logout();
        header("Location: /");
        exit();
        break;
    default:
        header("Location: /admin");
        exit();
}

if(is_array($out)) {
    $admin->getTemplate()->main('main');
    $admin->getTemplate()->set('{title}', $out['title']);
    $admin->getTemplate()->bloc('{sidebar}', 'sidebar', $out['side']);
    $admin->getTemplate()->bloc('{content}', $out['template'], $out['data']);
    $admin->getTemplate()->out();
}