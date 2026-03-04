<?php
/**
 * 2007-2025 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 *
 * @author    Anivista Art AB
 * @copyright 2007-2025 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class PlenquirySendModuleFrontController extends ModuleFrontController
{
    public $ajax = true;

    public function initContent()
    {
        parent::initContent();

        $question   = trim(Tools::getValue('question', ''));
        $name       = trim(Tools::getValue('name', ''));
        $email      = trim(Tools::getValue('email', ''));
        $page_url   = trim(Tools::getValue('page_url', ''));
        $page_title = trim(Tools::getValue('page_title', ''));

        if (empty($question)) {
            $this->ajaxRender(json_encode(['success' => false, 'error' => $this->module->l('Question is required.', 'send')]));
            exit;
        }

        if (!Validate::isEmail($email)) {
            $this->ajaxRender(json_encode(['success' => false, 'error' => $this->module->l('A valid email address is required.', 'send')]));
            exit;
        }

        $recipient = Configuration::get('PLENQUIRY_EMAIL');
        if (empty($recipient)) {
            $recipient = Configuration::get('PS_SHOP_EMAIL');
        }

        $id_lang    = (int) $this->context->language->id;
        $id_shop    = (int) $this->context->shop->id;
        $shop_name  = Configuration::get('PS_SHOP_NAME');

        $template_vars = [
            '{firstname}'  => $name,
            '{email}'      => $email,
            '{page_title}' => $page_title,
            '{page_url}'   => $page_url,
            '{question}'   => nl2br(htmlspecialchars($question, ENT_QUOTES, 'UTF-8')),
            '{shop_name}'  => $shop_name,
        ];

        $subject = 'Question about: ' . $page_title;

        try {
            $result = Mail::Send(
                $id_lang,
                'plenquiry',
                $subject,
                $template_vars,
                $recipient,
                null,
                $email,
                $name,
                null,
                null,
                dirname(__FILE__) . '/../../mails/',
                false,
                $id_shop
            );

            if ($result) {
                $this->ajaxRender(json_encode(['success' => true]));
            } else {
                $this->ajaxRender(json_encode(['success' => false, 'error' => $this->module->l('Something went wrong. Please try again later.', 'send')]));
            }
        } catch (Exception $e) {
            PrestaShopLogger::addLog(
                'Plenquiry: failed to send email — ' . $e->getMessage(),
                3,
                null,
                'plenquiry',
                0,
                true
            );
            $this->ajaxRender(json_encode(['success' => false, 'error' => $this->module->l('Something went wrong. Please try again later.', 'send')]));
        }

        exit;
    }
}
