<?php

/**
 * Класс Admin
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Admin extends Core {

    /**
     * @return array
     */
    public function managementSettings() {
        return array(
            'template' => 'settings',
            'title' => 'Настройки скрипта',
            'data' => array(
                'data' => include $this->getRootDir() . '/data/settings.php',
                'select-order' => array(
                    0 => array(
                        'value' => 'price',
                        'name' => 'Цена',
                        'icon' => 'glyphicon-triangle-top'
                    ),
                    1 => array(
                        'value' => 'priceDESC',
                        'name' => 'Цена',
                        'icon' => 'glyphicon-triangle-bottom'
                    ),
                    2 => array(
                        'value' => 'name',
                        'name' => 'Название',
                        'icon' => 'glyphicon-triangle-top'
                    ),
                    3 => array(
                        'value' => 'nameDESC',
                        'name' => 'Название',
                        'icon' => 'glyphicon-triangle-bottom'
                    )
                ),
                'select-currency' => array(
                    0 => array(
                        'value' => 'RUR',
                        'name' => 'Рубли',
                        'icon' => 'glyphicon-ruble'
                    ),
                    1 => array(
                        'value' => 'EUR',
                        'name' => 'Евро',
                        'icon' => 'glyphicon-euro'
                    ),
                    2 => array(
                        'value' => 'USD',
                        'name' => 'Доллары',
                        'icon' => 'glyphicon-usd'
                    ),
                    3 => array(
                        'value' => 'UAH',
                        'name' => 'Гривны',
                        'icon' => 'icon-grivna'
                    ),
                )
            ),
            'side' => array(
                'title' => 'Опции',
                'data' => array(
                    array(
                        'name' => 'Редактирование профиля',
                        'class' => 'profile-edit',
                        'url' => '#'
                    )
                )
            )
        );
    }

    /**
     * @param int $limit
     * @param int $page
     * @param int | string $filter
     * @return array
     */
    public function managementDelivery($limit, $page, $filter = NULL) {

        $inactiveCount = $this->getEmailDelivery()->getInactiveCount();
        $allCount = $this->getEmailDelivery()->getCount();

        if(isset($filter)) {
            switch($filter){
                case 'inactive':
                    $count = $inactiveCount;
                    $data = $this->getEmailDelivery()->getInactive($limit, $page);
                    $url = '/admin/delivery/inactive/';
                    break;
            }
        } else {
            $count = $allCount;
            $data = $this->getEmailDelivery()->get($limit, $page);
            $url = '/admin/delivery/';
        }
        if($count > 0) {
            $pageCount = intval(($count - 1) / $limit) + 1;
        } else {
            $pageCount = 0;
        }
        return array(
            'template' => 'delivery',
            'title' => 'Управление email рассылками',
            'data' => array(
                'data' => $data,
                'count' => $count,
                'limit' => $limit,
                'url' => $url,
                'page-count' => $pageCount,
                'page' => $page,
            ),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Новая рассылка',
                        'class' => 'new-delivery',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'Все подписчики',
                        'badge' => $allCount,
                        'url' => '/admin/delivery',
                    ),
                    array(
                        'name' => 'Неактивные',
                        'badge' => $inactiveCount,
                        'url' => '/admin/delivery/inactive',
                    )
                )
            ),
        );
    }

    /**
     * @param bool $archive
     * @return array
     */
    public function managementFeedback($archive = FALSE) {

        $notArchiveCount = $this->getFeedback()->getAllNotArchiveCount();
        $archiveCount = $this->getFeedback()->getAllArchiveCount();

        if($archive) {
            $title = 'Обратная связь (Архив)';
            $count = $this->getFeedback()->getAllArchiveCount();
            $data = $this->getFeedback()->getAllArchive();
        } else {
            $title = 'Обратная связь';
            $count = $this->getFeedback()->getAllNotArchiveCount();
            $data = $this->getFeedback()->getAllNotArchive();
        }
        return array(
            'template' => 'feedback',
            'title' => $title,
            'data' => array(
                'archive' => $archive,
                'count' => $count,
                'data' => $data
            ),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Непрочитанные',
                        'badge' => $notArchiveCount,
                        'url' => '/admin/feedback',
                    ),
                    array(
                        'name' => 'Архив',
                        'badge' => $archiveCount,
                        'url' => '/admin/feedback/archive',
                    )
                ),
            )
        );
    }

    /**
     * @return array
     */
    public function managementSysPages() {
        return array(
            'template' => 'sys-pages',
            'title' => 'Системные страницы',
            'data' => array('data' => $this->getSysPages()->getAllPages()),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Управление страницами',
                        'url' => '/admin/pages',
                    )
                ),
            )
        );
    }

    /**
     * @return array
     */
    public function managementPages() {
        return array(
            'template' => 'pages',
            'title' => 'Страницы',
            'data' => array('data' => $this->getPages()->getAllPage()),
            'side' => array(
                'title' => 'Опции',
                'data' => array(
                    array(
                        'name' => 'Добавить',
                        'class' => 'page-add',
                        'url' => '#',
                    )
                ),
            )
        );
    }

    /**
     * @return array
     */
    public function managementService(){
        return array(
            'template' => 'service',
            'title' => 'Обслуживание скрипта',
            'data' => '',
            'side' => array(
                'title' => 'Действие',
                'data' => array(
                    array(
                        'name' => 'Очистить весь кэш',
                        'class' => 'all-cache-clear',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'Очистить кэш разделов',
                        'class' => 'section-cache-clear',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'Очистить кэш товаров',
                        'class' => 'goods-cache-clear',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'Очистить кэш продавцов',
                        'class' => 'seller-cache-clear',
                        'url' => '#',
                    )
                ),
            )
        );
    }

    /**
     * @return array
     */
    public function managementEditor() {
        return array(
            'template' => 'editor',
            'title' => 'Редактирование шаблонов',
            'data' => array('data' => NULL),
            'side' => array(
                'title' => 'Файлы',
                'design-edit' => TRUE,
            )
        );
    }

    /**
     * @return array
     */
    public function managementStatistics() {
        return array(
            'template' => 'statistics',
            'title' => 'Статистика посещений',
            'data' => $this->getStat(10),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Журнал запросов',
                        'class' => 'view-log',
                        'url' => '#',
                    )
                )
            ),
        );
    }

    /**
     * @param string $page
     * @return array
     */
    public function getSysPageEditData($page) {
        if($page == 'not-found') {
            return array(
                'page' => 'not-found',
                'content' => $this->getSysPages()->getNotFoundPage()
            );
        } else {
            return NULL;
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function getPageEditData($id) {
        return array('data' => $this->getPages()->getOnePageById($id));
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUserEditData($id) {
        return array('data' => $this->getDb()->getRow("SELECT * FROM users WHERE id = ?i", $id));
    }

}