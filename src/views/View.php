<?php

namespace App\Views;

/**
 * Class representing a view
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class View {
    /**
     * Public method generating the HTML header tag of the page
     *
     * @param String|Null $name The page's titled
     * @param Array<String>|Null $cssFiles The array containing the css files to include at the page
     * @return void
     */
    public function generateCommonHeader(?string $name = null, ?array $cssFiles = null) { include COMMON.DS.'header.php'; }
    /**
     * Public method generating the HTML footer tag of the page
     *
     * @return Void
     */
    public function generateCommonFooter() { include COMMON.DS.'footer.php'; }
    /**
     * Public method generating the navigation menu
     *
     * @param Bool $form Boolean explaining if the navbarre is in a form page, or not
     * @param String|Null $currentPage The current tab
     * @return Void
     */
    public function generateMenu(bool $form = false, ?string $currentPage = null) { include BARRES.DS.'navbarre.php'; }

    /**
     * Public method generating a list.php from an data array
     *
     * @param String $title The list title
     * @param Array|Null $items The data array
     * @param Int|Null $nb_items_max The maximum number of elements
     * @param String|Null $id The HTML id of the list
     * @param String|Null $class The HTML class of the list
     * @param String|Null $direction If the items in the list are clickable, shows the redirect url
     * @return Void
     */
    public function getListItems(string $title, ?array $items = null, ?int $nb_items_max = null, ?string $id = null, ?string $class = null, ?string $direction = null) {
        if(!$nb_items_max)
            $nb_items_max = empty($items) ? 0 : count($items);
        include MY_ITEMS.DS.'list.php';
    }
    /**
     * Public method generating a buble with an data array
     * 
     * ! `link_add` and `link_consult` are not not usable !
     *
     * @param String $title The bubble's title
     * @param Array|Null $items The data array
     * @param Int|Null $nb_items_max The maximum number of elements
     * @param String|Null $link_add The url towards which redirect the user to add a new item in the bubble 
     * @param String|Null $link_consult The url towards which redirect the user to consult the complet list 
     * @return Void
     */
    public function getBubble(string $title, ?array $items = null, ?int $nb_items_max = null, ?string $link_add = null, ?string $link_consult = null) { include(MY_ITEMS.DS.'bubble.php'); }
    /**
     * Public method generating a dashborad from an data array
     *
     * @param Array $dashboard The data array
     * @return Void
     */
    public function getDashboard(array $dashboard) {
        foreach($dashboard as $item) {
            $title = $item['titre'];
            $items = $item['content'];
            $nb_items_max = isset($item['nb_item_max']) ? $item['nb_item_max'] : null;
            $link_add = isset($item['link_add']) ? $item['link_add'] : null;
            $link_consult = isset($item['link_consult']) ? $item['link_consult'] : null;

            $this->getBubble($title, $items, $nb_items_max, $link_add, $link_consult);
        }
    }
}