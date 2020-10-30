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
        $tickets = null;
        $eventId = Tools::getValue('eventId');
        $token = Tools::getValue('_token');
        if($eventId) $tickets = $this->getAllTickets($eventId);

        return $this->render('@Modules/eventticketslist/views/templates/admin/index.html.twig', [
            'events' => $this->getAllFutureEvents(),
            'options' => ['s', 'p', 'd'],
            'token' => $token,
            'tickets' => $tickets,
            'eventId' => $eventId,
            'formAction' => 'https://mightygames.ch/b8scuoivlwbgywbs/index.php/modules/eventticketslist/'
        ]);
    }

    protected function getAllFutureEvents()
    {
        $sql = new DbQuery();
        $sql->select('e.id_event as id, e.on_date as date, pl.name as name');
        $sql->from('aeb_product_event', 'e');
        $sql->innerJoin('product', 'p', 'e.id_product = p.id_product');
        $sql->innerJoin('product_lang', 'pl', 'p.id_product = pl.id_product');
        $sql->where('NOT e.end_date < NOW()');
        $sql->where('pl.id_lang = 3');
        $sql->orderBy('e.end_date');
        return Db::getInstance()->executeS($sql);
    }

    protected function getAllTickets($eventId)
    {
        $sql = new DbQuery();
        $sql->select('
        	t.id_ticket as ticketId,
        	o.current_state as state, 
        	pl.name as event, 
        	e.id_event as eventId, 
        	c.firstname as firstName, 
        	c.lastname as lastName');
        $sql->from('aeb_event_tickets', 't');
        $sql->innerJoin('orders', 'o', 't.id_order = o.id_order');
        $sql->innerJoin('customer', 'c', 'o.id_customer = c.id_customer');
        $sql->innerJoin('order_detail', 'od', 't.id_order_detail = od.id_order_detail');
        $sql->innerJoin('product', 'p', 'od.product_id = p.id_product');
        $sql->innerJoin('product_lang', 'pl', 'p.id_product = pl.id_product');
        $sql->innerJoin('aeb_product_event', 'e', 'e.id_product = p.id_product');
        $sql->where('pl.id_lang = 3');
        $sql->where('e.id_event = '.$eventId);
        $sql->where('o.current_state = 22');
        $sql->orderBy('c.firstname, c.lastname');
        return Db::getInstance()->executeS($sql);
    }
}
