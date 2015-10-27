<?php namespace impcthub;

// Remove prefix 'protected' and 'private' prefixes from posts
add_filter('the_title', '\impcthub\the_title_trim');
function the_title_trim($title) {
  $title = esc_attr($title);
  $findthese = array(
    '#Protected:#', // # is just the delimeter
    '#Private:#',
    '#Privat:#',
    );
  $replacewith = array(
    '', // What to replace protected with
    '', // What to replace private with
    ''
    );
  $title = preg_replace($findthese, $replacewith, $title);
  return $title;
}

?>
