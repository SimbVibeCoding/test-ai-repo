<?php

// A callback function to add a custom field to our "presenters" taxonomy
function presenters_taxonomy_custom_fields($tag)
{
    // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option("taxonomy_term_$t_id"); // Do the check
?>

<tr class="form-field">
    <th scope="row" valign="top">
        <label for="presenter_id"><?php _e('WordPress User ID'); ?></label>
    </th>
    <td>
        <input type="text" name="term_meta[presenter_id]" id="term_meta[presenter_id]" size="25" style="width:60%;" value="<?php echo $term_meta['presenter_id'] ? $term_meta['presenter_id'] : ''; ?>"><br />
        <span class="description"><?php _e('The Presenter\'s WordPress User ID'); ?></span>
    </td>
</tr>

<?php
}
// A callback function to save our extra taxonomy field(s)
add_action( 'cat-realizzazioni_edit_form_fields', 'extra_tax_fields', 10, 2);
//add extra fields to custom taxonomy edit form callback function
function extra_tax_fields($tag)
{
    //check for existing taxonomy meta for term ID
    $t_id = $tag->term_id;
    $term_meta = get_option("taxonomy_$t_id"); ?>
      <tr class="form-field">

      <tr class="form-field">
        <th scope="row" valign="top"><label for="colore"><?php _e('Colore'); ?></label></th>
          <td>
              <input type="text" name="term_meta[colore]" id="term_meta[colore]" size="25" style="width:60%;" value="<?php echo $term_meta['colore'] ? $term_meta['colore'] : ''; ?>"><br />
              <span class="description"><?php _e('colore'); ?></span>
          </td>
      </tr>

<?php
}
add_action( 'edited_cat-realizzazioni', 'save_extra_taxonomy_fileds', 10, 2);
// save extra taxonomy fields callback function
function save_extra_taxonomy_fileds( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
            foreach ($cat_keys as $key){
            if (isset($_POST['term_meta'][$key])){
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array
        update_option( "taxonomy_$t_id", $term_meta );
    }
}
