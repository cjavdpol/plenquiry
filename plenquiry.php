<?php
/**
 * 2007-2025 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 *
 * @author    Anivista Art AB
 * @copyright 2007-2025 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Plenquiry extends Module implements WidgetInterface
{
    const CONFIG_EMAIL = 'PLENQUIRY_EMAIL';

    public function __construct()
    {
        $this->name = 'plenquiry';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Anivista Art AB';
        $this->need_instance = 0;
        $this->bootstrap = true;

        $this->ps_versions_compliancy = [
            'min' => '8.1.0',
            'max' => '8.9.99',
        ];

        parent::__construct();

        $this->displayName = $this->l('Page Enquiry');
        $this->description = $this->l('Let visitors send a question about the current page to a configurable email address.');
    }

    public function install()
    {
        return parent::install()
            && Configuration::updateValue(self::CONFIG_EMAIL, Configuration::get('PS_SHOP_EMAIL'))
            && $this->registerHook('actionFrontControllerSetMedia');
    }

    public function uninstall()
    {
        return parent::uninstall()
            && Configuration::deleteByName(self::CONFIG_EMAIL);
    }

    public function hookActionFrontControllerSetMedia()
    {
        Media::addJsDef([
            'plenquiry_i18n' => [
                'success'       => $this->l('Thank you! Your question has been sent.'),
                'error_generic' => $this->l('Something went wrong. Please try again later.'),
                'error_network' => $this->l('Something went wrong. Please try again later.'),
            ],
        ]);

        $this->context->controller->registerStylesheet(
            'plenquiry-css',
            'modules/' . $this->name . '/views/css/plenquiry.css',
            ['media' => 'all', 'priority' => 200]
        );
        $this->context->controller->registerJavascript(
            'plenquiry-js',
            'modules/' . $this->name . '/views/js/plenquiry.js',
            ['position' => 'bottom', 'priority' => 200]
        );
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));

        return $this->fetch('module:plenquiry/views/templates/widget/plenquiry.tpl');
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        return [
            'plenquiry_action' => $this->context->link->getModuleLink($this->name, 'send', [], true),
            'show_name_field'  => isset($configuration['show_name_field']) ? $configuration['show_name_field'] : 'yes',
            'form_title'       => isset($configuration['form_title']) ? $configuration['form_title'] : '',
            'button_text'      => isset($configuration['button_text']) ? $configuration['button_text'] : '',
        ];
    }

    public function getContent()
    {
        $output = [];

        if (Tools::isSubmit('submitPlenquiry')) {
            $email = Tools::getValue(self::CONFIG_EMAIL);
            if (!Validate::isEmail($email)) {
                $output[] = $this->displayError($this->l('Invalid email address.'));
            } else {
                Configuration::updateValue(self::CONFIG_EMAIL, $email);
                $output[] = $this->displayConfirmation($this->l('Settings updated.'));
            }
        }

        $helper = new HelperForm();
        $helper->submit_action = 'submitPlenquiry';
        $helper->fields_value[self::CONFIG_EMAIL] = Configuration::get(self::CONFIG_EMAIL);

        $output[] = $helper->generateForm([
            [
                'form' => [
                    'legend' => [
                        'title' => $this->displayName,
                        'icon' => 'icon-envelope',
                    ],
                    'input' => [
                        [
                            'type' => 'text',
                            'label' => $this->l('Recipient email address'),
                            'name' => self::CONFIG_EMAIL,
                            'desc' => $this->l('Questions submitted via the widget will be sent to this address.'),
                            'required' => true,
                        ],
                    ],
                    'submit' => [
                        'title' => $this->l('Save'),
                    ],
                ],
            ],
        ]);

        return implode('', $output);
    }
}
