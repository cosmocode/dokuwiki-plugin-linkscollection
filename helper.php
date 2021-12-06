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
        $index = new \dokuwiki\Ui\Index($IDX);

        search($data, $conf['datadir'], 'search_index', ['ns' => '']);

        return '<div id="plugin_linkscollection__tree" class="index__tree">'
            . html_buildlist($data, 'idx', [$index,'formatListItem'], [$index,'tagListItem'])
            . '</div>';
    }
}
