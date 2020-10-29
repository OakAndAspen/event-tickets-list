<?php

namespace PrestaShop\Module\EventTicketsList\Controller;

use PrestaShop\PrestaShop\Adapter\Entity\Db;
use PrestaShop\PrestaShop\Adapter\Entity\DbQuery;
use PrestaShop\PrestaShop\Adapter\Entity\Tools;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class AdminEventTicketsController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
        $events = null;
        $option = Tools::getValue('option');
        if($option) $events = $this->getAllFutureEvents($option);

        return $this->render('@Modules/eventticketslist/views/templates/admin/index.html.twig', [
            'events' => $events,
            'options' => ['s', 'p', 'd'],
            'token' => Tools::getAdminTokenLite('AdminModules')
        ]);
    }

    protected function getAllFutureEvents($option)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('tab', 't');
        $sql->where('t.class_name LIKE "%'.$option.'"');
        return Db::getInstance()->executeS($sql);
    }
}
