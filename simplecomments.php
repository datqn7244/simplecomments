<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class SimpleComments extends Module
{
    public function __construct()
    {
        $this->name = 'simplecomments';
        $this->author = 'Dat Nguyen';
        $this->version = '1.0.0';
        $this->bootstrap = true;
        parent:: __construct();
        $this->displayName = $this->l('Simple comments module');
        $this->description = $this->l('Module to display comments on product page');
        $this->confirmUninstall = $this->l('Are you sure?');
    }

    public function install()
    {
        // A table to store review information will be create within the installation process
        include_once($this->local_path.'sql/install.php');
        if (!parent::install()) {
            return false;
        }
        if (!$this->registerHook('displayProductExtraContent')) {
            return false;
        }
        if (!$this->registerHook('displayHeader')) {
            return false;
        }
        if (!$this->registerHook('displayProductListReviews')) {
            return false;
        }
        if (!$this->registerHook('displayAdminProductsExtra')) {
            return false;
        }
        if (!$this->registerHook('actionProductSave')) {
            return false;
        }
        // After register all the hook, 3 value will be add to the database
        // to enable the review form.
        Configuration::updateValue('SIMPLECOMMENTS_GRADES', '1');
        Configuration::updateValue('SIMPLECOMMENTS_COMMENTS', '1');
        Configuration::updateValue('SIMPLECOMMENTS_REVIEWS', '1');
        return true;
    }

    public function uninstall()
    {
        // Installed database will be deleted when uninstall
        include_once($this->local_path.'sql/uninstall.php');
        if (!parent::uninstall()) {
            return false;
        }
        // the 3 added value will also be deleted.
        Configuration::deleteByName('SIMPLECOMMENTS_GRADES');
        Configuration::deleteByName('SIMPLECOMMENTS_COMMENTS');
        Configuration::deleteByName('SIMPLECOMMENTS_REVIEWS');
        return  true;
    }

    // Register css file to the displayHeader hook.
    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/simplecomments.css', 'all');
    }
    //Display Module Configuration
    public function getContent()
    {
        $this->processConfiguration();
        // $html_confirmation_message = $this->display(__FILE__, 'views/templates/admin/configuration.tpl');
        $html_form = $this->renderForm();
        return $html_form;
    }
    //Receive the value from the configuration form and update the database
    public function processConfiguration()
    {
        if (Tools::isSubmit('simple_comments_form')) {
            $enable_grades = Tools::getValue('enable_grades');
            $enable_comments = Tools::getValue('enable_comments');
            Configuration::updateValue('SIMPLECOMMENTS_GRADES', $enable_grades);
            Configuration::updateValue('SIMPLECOMMENTS_COMMENTS', $enable_comments);
        }
    }
    // Display the Review tab on product page with DisplayProductExtraContent hook
    public function hookDisplayProductExtraContent($params)
    {
        $this->processComment();
        $this->retrieveComment();
        $enable_reviews = Configuration::get('SIMPLECOMMENTS_REVIEWS');
        $array = array();
        $templateFile = 'module:simplecomments/views/templates/hook/simplecomments.tpl';
        $array[] = (new PrestaShop\PrestaShop\Core\Product\ProductExtraContent()) ->setTitle('Reviews') ->setContent($this->fetch($templateFile));
        // Display the review tab if it's enabled in product back office.
        if ($enable_reviews==1) {
            return $array;
        }
    }
    // Receive review information and add to the database
    public function processComment()
    {
        if (Tools::isSubmit('simplecomments_submit_comment')) {
            $insert = array(
            'id_product' => (int)Tools::getValue('id_product'),
            'firstname' =>  pSQL(Tools::getValue('firstname')),
            'lastname' =>  pSQL(Tools::getValue('lastname')),
            'email' =>  pSQL(Tools::getValue('email')),
            'grade' => (int)Tools::getValue('grade'),
            'comment' => pSQL(Tools::getValue('comment')),
            'date_add' => date('Y-m-d H:i:s'),
            );
            Db::getInstance()->insert('simplecomments', $insert);
            $this->context->smarty->assign('new_comment_posted', 'true');
        }
    }
    // Retrieve review information from the database, based on product id.
    public function retrieveComment()
    {
        $id_product = Tools::getValue('id_product');
        $sqls='SELECT * FROM`'._DB_PREFIX_.'simplecomments` WHERE `id_product` ='.(int)$id_product;
        $this->context->smarty->assign(array(
            'enable_grades' => Configuration::get('SIMPLECOMMENTS_GRADES'),
            'enable_comments' => Configuration::get('SIMPLECOMMENTS_COMMENTS'),
            'comments' =>Db::getInstance()->executeS($sqls)
        ));
    }
    // Use DisplayProductListReviews hook to display the rating to home.
    public function hookDisplayProductListReviews($params)
    {
        $enable_reviews = Configuration::get('SIMPLECOMMENTS_REVIEWS');
        $product = $params['product'];
        $id_product=$product->id_product;
        $sqls='SELECT ROUND(AVG(grade)) FROM`'._DB_PREFIX_.'simplecomments` WHERE `id_product` ='.(int)$id_product;
        $this->context->smarty->assign(array(
            'enable_grades' => Configuration::get('SIMPLECOMMENTS_GRADES'),
            'grade' =>Db::getInstance()->getValue($sqls),
            'product'=>$id_product
        ));
        if ($enable_reviews==1) {
            return $this->display(__FILE__, 'views/templates/hook/listreviews.tpl');
        }
    }
    // Add option to product back office under Modules
    // I tried with helper form but it doesn't work
    public function hookDisplayAdminProductsExtra($params)
    {
        $enable_reviews = Configuration::get('SIMPLECOMMENTS_REVIEWS');
        
        $this->context->smarty->assign(array(
            'enable_reviews' => $enable_reviews,
            'test'=> $_REQUEST
        ));
        return $this->display(__FILE__, 'views/templates/admin/productconfigs.tpl');
    }
    // use ActionProductSave hook to retrieve value from POST
    // and update value to the database
    public function hookActionProductSave()
    {
        $enable_reviews = Tools::getValue('enable_reviews');
        Configuration::updateValue('SIMPLECOMMENTS_REVIEWS', $enable_reviews);
    }
    // RenderForm for module configuration page
    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
            'legend' => array(
            'title' => $this->l('My Module configuration'),
            'icon' => 'icon-envelope'
            ),
            'input' => array(
            array(
            'type' => 'switch',
            'label' => $this->l('Enable grades:'),
            'name' => 'enable_grades',
            'desc' => $this->l('Enable grades on products.'),
            'values' => array(
            array(
            'id' => 'enable_grades_1',
            'value' => 1,
            'label' => $this->l('Enabled')
            ),
            array(
            'id' => 'enable_grades_0',
            'value' => 0,
            'label' => $this->l('Disabled'))
        ),
        ),
        array(
        'type' => 'switch',
        'label' => $this->l('Enable comments:'),
        'name' => 'enable_comments',
        'desc' => $this->l('Enable comments on products.'),
        'values' => array(
        array(
        'id' => 'enable_comments_1',
        'value' => 1,
        'label' => $this->l('Enabled')
        ),
        array(
        'id' => 'enable_comments_0',
        'value' => 0,
        'label' => $this->l('Disabled')
        )
        ),
        ),
        ),
        'submit' => array(
        'title' => $this->l('Save'),
        )
        ),
       );
        $helper = new HelperForm();
        $helper->table = 'simplecomments';
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        $helper->submit_action = 'simple_comments_form';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array('fields_value' => array(
        'enable_grades' => Tools::getValue(
            'enable_grades',
            Configuration::get('SIMPLECOMMENTS_GRADES')
        ),
        'enable_comments' => Tools::getValue(
            'enable_comments',
            Configuration::get('SIMPLECOMMENTS_COMMENTS')
        ),
        ),
        'languages' => $this->context->controller->getLanguages()
    );
        return $helper->generateForm(array($fields_form));
    }
}
