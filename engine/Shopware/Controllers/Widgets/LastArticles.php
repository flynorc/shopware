<?php
/**
 * Shopware 4.0
 * Copyright © 2012 shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Shopware_Controllers_Widgets
 * @subpackage Widgets
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author     Heiner Lohaus
 * @author     $Author$
 */

/**
 * Shopware Application
 *
 * todo@all: Documentation
 */

class Shopware_Controllers_Widgets_LastArticles extends Enlight_Controller_Action
{
    /**
     * Sets a template variable with the last views articles.
     *
     * @return void
     */
    public function indexAction()
    {
        $articleId = (int) $this->Request()->getParam('sArticle');
        $articles = Shopware()->Modules()->Articles()->sGetLastArticles($articleId);
        $this->View()->assign('sLastArticles', $articles, true);

        $plugin = Shopware()->Plugins()->Frontend()->LastArticles();
        if(!empty($articleId)) {
            $plugin->setLastArticleById($articleId);
        }
    }
}
