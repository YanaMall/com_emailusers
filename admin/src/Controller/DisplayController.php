<?php

namespace AM\Component\emailusers\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

/**
 * @package     Joomla.Administrator
 * @subpackage  com_emailusers
 *
 * @copyright   Copyright (C) 2022 Ayiana Mallory. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

/**
 * Default Controller of HelloWorld component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_emailusers
 */
class DisplayController extends BaseController {
    /**
     * The default view for the display method.
     *
     * @var string
     */
    protected $default_view = 'home';
    
    public function display($cachable = false, $urlparams = array()) {
        return parent::display($cachable, $urlparams);
    }
    
}