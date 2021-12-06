/**
 * Reuses parts of lib/scripts/tree.js
 */

jQuery(function () {

    // namespace links
    const toggleSelector = 'a.idx_dir';

    /**
     * Translates selected pages into syntax and inserts it into editor
     *
     * @param e
     * @returns {boolean}
     */
    const insert = function (e) {
        if (!window.opener) return false;

        e.preventDefault();
        e.stopPropagation();

        const $items = $tree.find("input[type=checkbox]:checked").toArray();

        const syntaxArray = $items.map(function (item) {
            const $item = jQuery(item)[0];
            let id = $item.value;
            const nsRegex = new RegExp(':');
            if (nsRegex.test(id) === false) {
                id = ':' + id;
            }
            return "\n  * [[" + id + "]]";
        });

        const syntax = syntaxArray.join("");

        opener.insertAtCarret('wiki__text', syntax, '');
        window.close();
        opener.focus();

        return false;
    }

    // button for inserting syntax into the editor
    const $submitButton = jQuery('#plugin_linkscollection__insert');
    $submitButton.on('click', insert);

    /**
     * Handles toggling of namespace links
     *
     * @param e
     */
    const toggle = function (e) {

        const $nsLink = jQuery(this);
        const $listitem = $nsLink.closest('li');
        let $sublist = $listitem.find('ul').first();
        const opening = $listitem.hasClass('closed');

        e.preventDefault();

        // fetch sublist of currently clicked namespace
        const load_data = function (show_sublist, $nsLink) {
            jQuery.post(
                DOKU_BASE + 'lib/exe/ajax.php',
                $nsLink[0].search.substr(1) + '&call=index',
                show_sublist,
                'html'
            );
        }

        const show_sublist = function (data) {
            $sublist.hide();
            if (typeof data !== 'undefined') {

                const $tree = jQuery(data);
                addCheckboxes($tree);
                $sublist.prepend($tree);
            }
            if ($listitem.hasClass('open')) {
                // Only show if user didn't close the list since starting
                // to load the content
                $sublist.dw_show();
            }
        };

        if ($sublist.is(':visible')) {
            $listitem.removeClass('open').addClass('closed');
        } else {
            $listitem.removeClass('closed').addClass('open');
        }

        // if already open, close by hiding the sublist
        if (!opening) {
            $sublist.dw_hide();
            return;
        }

        // just show if already loaded
        if ($sublist.length > 0) {
            show_sublist();
            return;
        }

        //prepare the new ul
        $sublist = jQuery('<ul class="idx" role="group"/>');
        $listitem.append($sublist);

        load_data(function (data) {
            show_sublist(data);
        }, $nsLink);
    }

    /**
     * Add checkboxes to page links, skipping namespace links
     * @param $tree
     */
    const addCheckboxes = function ($tree) {
        $tree.find('a').not(toggleSelector).each(function () {

            const $link = jQuery(this);
            $link.on('click', function (e) {
                e.preventDefault();
            });

            const id = $link.prop('title');

            let $label = jQuery('<label for="'+ id + '"/>');
            let $checkbox = jQuery('<input type="checkbox" name="collection[]" value="' + id + '"  id="' + id + '" />');
            $label.prepend($checkbox);
            $label.insertBefore($link);
        });
    };

    /**
     * Main functionality of the script: attach events to page tree
     */
    const $tree = jQuery('#plugin_linkscollection__tree');

    const processTree = function ($tree) {
        $tree.find('a').click(function (e) {
            e.preventDefault();
        });

        addCheckboxes($tree);
        $tree.on('click', toggleSelector, {data: $tree}, toggle);
    }

    if ($tree) {
        processTree($tree);
    }
});
