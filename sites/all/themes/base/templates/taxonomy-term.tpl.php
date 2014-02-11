<?php

/**
 * @file
 * Default theme implementation to display a term.
 *
 * Available variables:
 * - $name: (deprecated) The unsanitized name of the term. Use $term_name
 *   instead.
 * - $content: An array of items for the content of the term (fields and
 *   description). Use render($content) to print them all, or print a subset
 *   such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $term_url: Direct URL of the current term.
 * - $term_name: Name of the current term.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - taxonomy-term: The current template type, i.e., "theming hook".
 *   - vocabulary-[vocabulary-name]: The vocabulary to which the term belongs to.
 *     For example, if the term is a "Tag" it would result in "vocabulary-tag".
 *
 * Other variables:
 * - $term: Full term object. Contains data that may not be safe.
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $page: Flag for the full page state.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the term. Increments each time it's output.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_taxonomy_term()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?>">

  <?php if (!$page): ?>
    <h2><a href="<?php print $term_url; ?>"><?php print $term_name; ?></a></h2>
  <?php endif; ?>

  <div class="content">
    <?php

    $children = taxonomy_get_children($term->tid);

    if (!empty($children)) {

        print render($content['field_title']); 
         print render($content['description']['#markup']); 
        print render($content['field_image']);
        $i = 0;
        foreach ($children as $tid => $child) {
            
            $term_uri = entity_uri('taxonomy_term', $child);

            print l('<h2>'. ucfirst($term_uri['options']['entity']->name) .'</h2>', $term_uri['path'], array('html'=>true));
            
            if ($i == 0 && $nids = taxonomy_select_nodes($child->tid)) {
                print '<ul>';
                foreach ($nids as $nid) {
                    $node = node_load($nid);

                    $node_uri = entity_uri('node', $node);
                    print '<li>'. l($node_uri['options']['entity']->title, $node_uri['path']) .'</li>';

                }
                print '</ul>';             
            }
            
            $i++;
        }

    } else {

        print render($content['field_title']); 
        print render($content['description']['#markup']); 
        print render($content['field_image']);
        if ($nids = taxonomy_select_nodes($term->tid)) {
            print '<ul>';
            foreach ($nids as $nid) {
                $node = node_load($nid);
                $node_uri = entity_uri('node', $node);
                print '<li>'. l($node_uri['options']['entity']->title, $node_uri['path']) .'</li>';
            }
            print '</ul>';             
        }
    }

    ?>
  </div>

</div>