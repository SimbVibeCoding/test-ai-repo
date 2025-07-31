<?php
/* custom field nelle option/general della dashboard*/
function register_fields()
{
    register_setting('general', 'tagmanagerID', 'esc_attr');
    add_settings_field('tagmanagerID', '<label for="tagmanagerID">'.__('Tag Manager ID' , 'tagmanagerID' ).'</label>' , 'print_custom_field', 'general');
}

function print_custom_field()
{
    $value = get_option( 'tagmanagerID', '' );
    echo '<input type="text" id="tagmanagerID" name="tagmanagerID" value="' . $value . '" />';
}

add_filter('admin_init', 'register_fields');
/* FINE custom field nelle option/general della dashboard*/


//Avada
//add_filter( 'avada_before_body_content', 'my_custom_head_function_for_avada' );

//Enfold-->
//add_action('ava_after_main_container','tagmanagerBodyScript');

//Storefront
add_action( 'storefront_before_site', 'tagmanagerBodyScript' ,0);

//bootstrap-child
//aggiungere nel file header.php la riga
//do_action('bootstrap_child_before_site');
// poi nella function.php
//add_action( 'bootstrap_child_before_site', 'tagmanagerBodyScript' ,0);

add_action( 'wp_head', 'tagmanagerHeadScript' ,0);
function tagmanagerBodyScript(){
	?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo get_option( 'tagmanagerID', '' ); ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<?php
}
function tagmanagerHeadScript(){
?>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo get_option( 'tagmanagerID', '' ); ?>');</script>
<!-- End Google Tag Manager -->
<?php
}
