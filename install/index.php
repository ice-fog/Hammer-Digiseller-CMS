<?php

define('APP', true);

function __autoload($class)
{
    require $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class . '.php';
}

Registry::set('db-config', '/config/db-config.php');
Registry::set('templates-dir', '/install/templates/');
Registry::set('templates-ext', '.tpl');
Registry::set('cache-dir', '/cache/xml/');

/**
 * Class Installer
 */
class Installer
{

    private $settings;
    private $template;

    private static $instance;

    /**
     *
     */
    function __construct()
    {
        if (self::$instance) {
            $this->template = &self::$instance->template;
            $this->settings = &self::$instance->settings;
        } else {
            self::$instance = $this;
            $this->settings = new Settings();
            $this->template = new Template(
                $this->getRootDir() . Registry::get('templates-dir'),
                Registry::get('templates-ext')
            );
        }
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }


    /**
     * @return string
     */
    public function getHTTPHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param int $route
     * @return int | array
     */
    public function getRoute($route = 0)
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        if ($route == 0) {
            return $routes;
        } else {
            return $routes[$route];
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $time
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return bool
     */
    public function setCookie($key, $value, $time = 0, $path = null, $domain = null, $secure = false, $httpOnly = false)
    {
        return setcookie(md5($key), base64_encode($value), $time, $path, $domain, $secure, $httpOnly);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCookie($key)
    {
        if (isset($_COOKIE[md5($key)])) {
            return base64_decode($_COOKIE[md5($key)]);
        } else {
            return false;
        }

    }

    /**
     * @return array
     */
    public function checkSystem()
    {

        return array(
            'php-version' => phpversion(),
            'php-5-3' => phpversion() < '5.3' ? 0 : 1,
            'is-mysql' => function_exists('mysqli_connect') ? 1 : 0,
            'is-xml' => extension_loaded('xml') ? 1 : 0,
            'is-curl' => function_exists('curl_version') ? 1 : 0,
            'output-buffering' => ini_get('output_buffering') ? 1 : 0,
            'magic-quotes-runtime' => ini_get('magic_quotes_runtime') ? 'yes' : 0,
            'magic-quotes-gpc' => ini_get('magic_quotes_gpc') ? 1 : 0,
            'register-globals' => ini_get('register_globals') ? 1 : 0,
            'session-auto-start' => ini_get('session.auto_start') ? 1 : 0
        );
    }

    /**
     * @return array
     */
    public function checkFiles()
    {
        $files = array(
            '../cache/xml/goods',
            '../cache/xml/section',
            '../cache/xml/seller',
            '../files/images',
            '../files/images/thumbnail',
            '../config/db-config.php',
            '../data/settings.php',
            '../data/system-pages.php',
            '../data/log',
            '../.htaccess',
            '../admin/.htaccess',
        );

        $result = array();

        foreach ($files as $file) {
            if (!file_exists($file)) {
                $status = array(
                    'file' => str_replace('..', '', $file),
                    'text' => 'не найден!',
                    'error' => 1,
                    'chmod' => '-'
                );
                $result['not-found-error'] = true;
            } elseif (is_writable($file)) {
                $status = array(
                    'file' => str_replace('..', '', $file),
                    'text' => 'разрешено!',
                    'error' => 0,
                    'chmod' => @decoct(@fileperms($file)) % 1000,
                );
            } else {
                @chmod($file, 0777);
                if (is_writable($file)) {
                    $status = array(
                        'file' => str_replace('..', '', $file),
                        'text' => 'разрешено!',
                        'error' => 0,
                        'chmod' => @decoct(@fileperms($file)) % 1000,
                    );
                } else {
                    @chmod("$file", 0755);
                    if (is_writable($file)) {
                        $status = array(
                            'file' => str_replace('..', '', $file),
                            'text' => 'разрешено!',
                            'error' => 0,
                            'chmod' => @decoct(@fileperms($file)) % 1000,
                        );
                    } else {
                        $status = array(
                            'file' => str_replace('..', '', $file),
                            'text' => 'запрещено!',
                            'error' => 1,
                            'chmod' => @decoct(@fileperms($file)) % 1000,
                        );
                        $result['chmod-error'] = true;
                    }
                }
            }

            $result['files'][$file] = $status;
        }

        return $result;

    }

    /**
     * @param array $param
     */
    public function updateConfig($param)
    {
        file_put_contents($this->getRootDir() . '/config/db-config.php', "<?php\n\nreturn array(\n" .
            "\t'host' => '" . $param['host'] . "',\n" .
            "\t'user' => '" . $param['user'] . "',\n" .
            "\t'pass' => '" . $param['pass'] . "',\n" .
            "\t'db' => '" . $param['name'] . "',\n" .
            "\t'port' => NULL,\n" .
            "\t'socket' => NULL,\n" .
            "\t'pconnect' => FALSE,\n" .
            "\t'charset' => 'utf8',\n" .
            "\t'errmode' => 'error',\n" .
            "\t'exception' => 'Exception'\n);");
    }

    /**
     * @return bool
     */
    public function isInstall()
    {
        if ($this->getSettings()->settings['is-install']) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return array
     */
    public function licensePage()
    {
        return array(
            'template' => 'license',
            'title' => 'Лицензионное соглашение',
            'data' => array(
                'license-text' => file_get_contents($this->getRootDir() . '/install/data/license')
            )
        );
    }

    /**
     * @return array
     */
    public function systemPage()
    {
        return array(
            'template' => 'system',
            'title' => 'Проверка конфигурации',
            'data' => $this->checkSystem()

        );
    }

    /**
     * @return array
     */
    public function filesPage()
    {
        return array(
            'template' => 'files',
            'title' => 'Проверка системных файлов',
            'data' => $this->checkFiles()

        );
    }

    /**
     * @return array
     */
    public function configurationPage()
    {
        return array(
            'template' => 'config',
            'title' => 'Настройки конфигурации системы',
        );
    }

    /**
     * @return array
     */
    public function successPage()
    {
        return array(
            'template' => 'success',
            'title' => 'Установка успешно завершена',
        );
    }
}

$installer = new Installer();
$routes = $installer->getRoute();

if ($installer->isInstall()) {
    echo 'Скрипт уже установлен! Удалите директорию /install';
    return;
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    switch ($installer->getCookie('step')) {
        case null:
            $out = $installer->licensePage();
            break;
        case 'system':
            $out = $installer->systemPage();
            break;
        case 'files':
            $out = $installer->filesPage();
            break;
        case 'config':
            $out = $installer->configurationPage();
            break;
        case 'user':
            break;
        case 'success':
            $out = $installer->successPage();
            $installer->getSettings()->updateSettings(array('is-install' => 1));
            break;
    }

}

switch ($routes[2]) {
    case 'ajax':
        if ($_SERVER['REQUEST_METHOD'] == "POST" && is_string($_POST['action'])) {
            switch ($_POST['action']) {
                case 'accept-license':
                    if ($installer->setCookie('step', 'system')) {
                        echo 'ok';
                    }
                    break;
                case 'accept-system':
                    if ($installer->setCookie('step', 'files')) {
                        echo 'ok';
                    }
                    break;
                case 'accept-files':
                    if ($installer->setCookie('step', 'config')) {
                        echo 'ok';
                    }
                    break;
                case 'check-db-config':
                    if (!empty($_POST['db-host'])
                        && !empty($_POST['db-user'])
                        && !empty($_POST['db-name'])) {

                        $installer->updateConfig(array(
                            'host' => trim($_POST['db-host']),
                            'user' => trim($_POST['db-user']),
                            'pass' => trim($_POST['db-pass']),
                            'name' => trim($_POST['db-name'])
                        ));

                        $db = new DataBase(include $installer->getRootDir() . Registry::get('db-config'));
                        if ($db->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = ?s", trim($_POST['db-name']))) {
                            echo 'ok';
                        }
                    } else {
                        echo 'error';
                    }
                    break;
                case 'install':
                    if (!empty($_POST['db-host'])
                        && !empty($_POST['db-user'])
                        && !empty($_POST['db-name'])
                        && !empty($_POST['site-description'])
                        && !empty($_POST['site-login'])
                        && !empty($_POST['site-pass'])
                        && !empty($_POST['site-email'])
                        && !empty($_POST['site-agent-id'])
                        && !empty($_POST['site-xml-id'])) {

                        $installer->updateConfig(array(
                            'host' => trim($_POST['db-host']),
                            'user' => trim($_POST['db-user']),
                            'pass' => trim($_POST['db-pass']),
                            'name' => trim($_POST['db-name'])
                        ));

                        $db = new DataBase(include $installer->getRootDir() . Registry::get('db-config'));

                        $sql = explode('###', file_get_contents($installer->getRootDir() . '/install/data/db'));
                        foreach ($sql as $t) {
                            $db->query($t);
                        }

                        if ($db->query("UPDATE users SET login = ?s, password = ?s WHERE id = ?i", trim($_POST['site-login']), md5(md5(trim($_POST['site-pass']))), 1)) {
                            $settings = array(
                                'email' => $_POST['site-email'],
                                'xml-id' => $_POST['site-xml-id'],
                                'agent-id' => $_POST['site-agent-id'],
                                'site-title' => $_POST['site-title'],
                                'site-description' => $_POST['site-description']
                            );
                            $installer->getSettings()->updateSettings($settings);
                            if ($installer->setCookie('step', 'success')) {
                                echo 'ok';
                            }
                        }
                    } else {
                        echo 'error';
                    }
                    break;
            }
        }
        break;
}

if (is_array($out)) {
    $installer->getTemplate()->main('main');
    $installer->getTemplate()->set('{title}', $out['title']);
    $installer->getTemplate()->bloc('{content}', $out['template'], $out['data']);
    $installer->getTemplate()->out();
}