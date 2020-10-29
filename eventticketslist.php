<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

$loader = require __DIR__.'/vendor/autoload.php';
$loader->addPsr4('PrestaShop\\Module\\EventTicketsList\\Controller\\', __DIR__);

class EventTicketsList extends Module
{
    public function __construct()
    {
        $this->name = 'eventticketslist';
        $this->author = 'Irina Despot';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->bootstrap = true;

        parent::__construct();
        $this->displayName = 'Event tickets list';
        $this->description = 'Lists all available tickets for a chosen event';
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
    }

    public function install()
    {
        return parent::install()
            && $this->installModuleTab();
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    private function installModuleTab() {
        $tab = new Tab();

        $tab->name = [];
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "Event Tickets List";
        }

        $tab->route_name = "eventticketslist_index";
        $tab->class_name = "AdminEventTickets";
        $tab->module = $this->name;
        $tab->id_parent = 2;
        return $tab->add();
    }

    // Display the configuration page
    public function getContent()
    {
        $id = Tools::getValue('id_comment');
        $message = null;

        // Display the config page template
        $this->smarty->assign([
            'comments' => $this->getAllComments()
        ]);
        return $this->fetch(self::CONFIG_TEMPLATE);
    }

    // Return all comments from the database
    protected function getAllFutureEvents()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('tab', 't');
        return Db::getInstance()->executeS($sql);
    }
}
