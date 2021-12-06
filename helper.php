<?php

/**
 * DokuWiki Plugin linkscollection (Helper Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Anna Dabrowska <dokuwiki@cosmocode.de>
 */
class helper_plugin_linkscollection extends DokuWiki_Plugin {

    /**
     * Return sitemap HTML
     *
     * @return string
     */
    public function getSitemap()
    {
        global $IDX;
        global $conf;

        $data = [];
        search($data, $conf['datadir'], 'search_index', ['ns' => '']);


        // Hogfather compatibility
        if (class_exists('\dokuwiki\Ui\Index')) {
            $index = new \dokuwiki\Ui\Index($IDX);
            $html = html_buildlist($data, 'idx', [$index,'formatListItem'], [$index,'tagListItem']);
        } else {
            $html = html_buildlist($data, 'idx', 'html_list_index', 'html_li_index');
        }

        return '<div id="plugin_linkscollection__tree" class="index__tree">'
            . $html
            . '</div>';
    }
}
