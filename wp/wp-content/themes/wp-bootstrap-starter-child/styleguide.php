<?php /* Template Name: styleguide */ ?>
<?php
/**
*
* Layout per mostrare stili di default e mixins disponibili
*
* @package storefront
*/

get_header();
	//	var_dump(is_home());
?>
<div class="separatore"><h2>Gutemberg content</h2></div>
<section id="primary" class="content-area col-sm-12 col-lg-8">
  <main id="main" class="site-main" role="main">

    <?php
    while (have_posts()) : the_post();

    get_template_part('template-parts/content', 'page');

    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) :
      comments_template();
    endif;

  endwhile; // End of the loop.
  ?>

</main><!-- #main -->
</section><!-- #primary -->
<div class="separatore"><h2>TEST colonne bootstrap </h2></div>
<div class="container">
  <div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">col-12 col-sm-6 col-md-4 col-lg-3</div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">col-12 col-sm-6 col-md-4 col-lg-3</div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">col-12 col-sm-6 col-md-4 col-lg-3</div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">col-12 col-sm-6 col-md-4 col-lg-3</div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">col-12 col-sm-6 col-md-4 col-lg-3</div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">col-12 col-sm-6 col-md-4 col-lg-3</div>
  </div>
</div>

<div class="separatore"><h2>Styleguide</h2></div>


<div class="separatore"><h2>Bootstrap su colonne custom</h2></div>
<!--.custom-container-class>.custom-row-class#row-id${}*3>.custom-col-class#col-id${ colonna$}*6-->
<div class="custom-container-class">
  <div class="custom-row-class" id="row-id1">
    <div class="custom-col-class" id="col-id1"> </div>
    <div class="custom-col-class" id="col-id2"> </div>
    <div class="custom-col-class" id="col-id3"> </div>
    <div class="custom-col-class" id="col-id4"> </div>
    <div class="custom-col-class" id="col-id5"> </div>
    <div class="custom-col-class" id="col-id6"> </div>
  </div>
  <div class="custom-row-class" id="row-id2">
    <div class="custom-col-class" id="col-id1"> </div>
    <div class="custom-col-class" id="col-id2"> </div>
    <div class="custom-col-class" id="col-id3"> </div>
    <div class="custom-col-class" id="col-id4"> </div>
    <div class="custom-col-class" id="col-id5"> </div>
    <div class="custom-col-class" id="col-id6"> </div>
  </div>
  <div class="custom-row-class" id="row-id3">
    <div class="custom-col-class" id="col-id1"> </div>
    <div class="custom-col-class" id="col-id2"> </div>
    <div class="custom-col-class" id="col-id3"> </div>
    <div class="custom-col-class" id="col-id4"> </div>
    <div class="custom-col-class" id="col-id5"> </div>
    <div class="custom-col-class" id="col-id6"> </div>
  </div>
</div>
<div id="styleguide">
  <div class="separatore"><h3>Headings</h3></div>
  <h1 title="default title">Header 1 default</h1>
  <h1 class="post-title" title="post-title">Header 1 post-title</h1>
  <h1 class="page-title" title="post-title">Header 1 page-title</h1>
  <h2 title="heading2">Header 2</h2>
  <h3 title="heading3">Header 3</h3>
  <h4 title="heading4">Header 4</h4>
  <h5 title="heading5">Header 5</h5>
  <h6 title="heading6">Header 6</h6>


  <section>sfumatura</section>
  <div class="sfumatura"></div>

  <section>paragrafi</section>
  <p class="default" title="item1"> Lorem ipsum 1 <a class="mainlink" href="#">link1</a></p>
  <p class="categoria" title="item2"> Lorem ipsum 2 <a href="#">link2</a></p>
  <p class="footer" title="item3"> Lorem ipsum 3 <a href="#">link3</a></p>

  <section>colori</section>
  <ul class="colors color-main">
    <li class="item item1">color-main 1</li>
    <li class="item item2">color-main 2</li>
    <li class="item item3">color-main 3</li>
    <li class="item item4">color-main 4</li>
  </ul>
  <ul class="colors color-neutri">
    <li class="item item5">color-neutro1 </li>
    <li class="item item6">color-neutro2 </li>
    <li class="item item7">color-neutro3 </li>
    <li class="item item8">color-neutro4 </li>

  </ul>
  <section>pulsanti</section>
  <button class="button button1">button 1</button>

	<section>grid</section>
<div class="grid">
	<div class="container">
		<div class="row">
			<div class="item item1">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item2">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)stretch (default): stretch to fill the container (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item3">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)stretch (default): stretch to fill the container (still respect min-width/max-width)stretch (default): stretch to fill the container (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item4">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item5">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fillstretch (default): stretch to fill the container (still respect min-width/max-width)min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item6">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)stretch (default): stretch to (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item7">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item8">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretstretch (default): stretch to fill the container (still respect min-width/max-width)ax-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item9">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item10">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item11">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/mill respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
			<div class="item item12">
				<div class="sub sub1"><h2>titolo</h2></div>
				<div class="sub sub2">stretch (default): stretch to fill the container (still respect min-width/max-width)stretch (default): stretch to fill the container (still respect min-width/max-width)stretch (default): stretch to fill the container (still respect min-width/max-width)</div>
				<div class="sub sub3"></div>
			</div>
		</div>
	</div>
</div>
<div class="aaa">
  <div class="bbb">
    <div class="ccc1">col1</div>
    <div class="ccc2">col2</div>
    <div class="ccc3">col3</div>
  </div>
</div>
</div>
</body>
</html>
