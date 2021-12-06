<?php
/**
 * DokuWiki Plugin linkscollection (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Anna Dabrowska <dokuwiki@cosmocode.de>
 */
class action_plugin_linkscollection_button extends DokuWiki_Action_Plugin
{

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     *
     * @return void
     */
    public function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'addEditorButton');
    }

    /**
     * Add button to editor toolbar
     *
     * @param Doku_Event $event  event object by reference
     * @return void
     */
    public function addEditorButton(Doku_Event $event)
    {
        $event->data[] = [
            'type' => 'mediapopup',
            'title' => 'Links collection',
            'icon' => '../../plugins/linkscollection/images/toolbar/link-variant-plus.png',
            'block'  => false,
            'url' => 'lib/plugins/linkscollection/exe/tree.php?idx=',
            'name' => 'Link collection',
            'options' => 'width=950,height=800,left=20,top=20,scrollbars=yes,resizable=yes',
        ];
    }
}

