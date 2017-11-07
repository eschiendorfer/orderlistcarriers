<?php
/**
 * Copyright (C) 2017 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <modules@thirtybees.com>
 * @copyright 2017 thirty bees
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_TB_VERSION_')) {
    exit;
}

/**
 * Class OrderListCarriers
 */
class OrderListCarriers extends Module
{
    /**
     * OrderListCarriers constructor.
     */
    public function __construct()
    {
        $this->name = 'orderlistcarriers';
        $this->tab = 'administration';
        $this->version = '1.0.1';
        $this->author = 'thirty bees';

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Carrier on order list ');
        $this->description = $this->l('Show carriers on the order list of the admin panel');
    }

    /**
     * Install the module
     *
     * @return bool
     */
    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        $this->registerHook('actionAdminOrdersListingFieldsModifier');

        return true;
    }

    /**
     * Edit order grid display
     *
     * @param array $params
     */
    public function hookActionAdminOrdersListingFieldsModifier($params)
    {
        if (!isset($params['join'])) {
            $params['join'] = '';
        }
        $params['join'] .= "\n\t\tLEFT JOIN `"._DB_PREFIX_.bqSQL(Carrier::$definition['table'])."` olcarrier ON (a.`id_carrier` = olcarrier.`id_carrier`)";
        $params['fields']['olcarrier!name'] = [
            'title'           => $this->l('Carrier'),
            'align'           => 'center',
            'class'           => 'fixed-width-xs',
            'filter_key'      => 'olcarrier!name',
            'type'            => 'text',
        ];
    }
}
