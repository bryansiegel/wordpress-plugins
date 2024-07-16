<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	add_action('goodlayers_core_course_search_content', 'goodlayers_core_course_search_content', 10, 1);
	if( !function_exists('goodlayers_core_course_search_content') ){
		function goodlayers_core_course_search_content( $settings ){

			$search_template = apply_filters('gdlr_core_course_search_template', '');

			if( !isset($_GET['course-keywords']) ){ 
				if( empty($search_template) || $search_template != get_the_ID() ){
					return ''; 
				}
			}

?>
<div class="gdlr-core-course-search-page" >
<!-- Search Mobile -->
<div class="school-search-mobile">
<div class="gdlr-core-course-search-item gdlr-core-item-pdb gdlr-core-item-pdlr">
    <div class="gdlr-core-search-frame" style="background-color:#1f2d4a;">
        <h3 class="gdlr-core-course-search-item-title " style="color: #ffffff ;">Search For Magnet Schools</h3>
        <form class="gdlr-core-course-form clearfix" action="https://magnetschoolsdreampress.stage.site/find-a-magnet-school/" method="GET">
            <div class=" gdlr-core-course-column gdlr-core-column-1 gdlr-core-column-first">
                <div class="gdlr-core-course-search-field gdlr-core-course-field-keywords"><input type="text" placeholder="Keywords" name="course-keywords" value=""></div>
            </div>
            <?php foreach ($settings['search-fields'] as $search_options) : ?>
            	<?php if($search_options != "keywords") { ?>
					<?php 
            			$terms = gdlr_core_get_term_list($search_options);
            			$tax_list = array(
						'course_category' => esc_html__('Course Category', 'goodlayers-core-course'),
						'course_tag' => esc_html__('Course Tag', 'goodlayers-core-course')
					) + goodlayers_core_course_get_custom_tax_list();
            		 ?>
            <div class=" gdlr-core-course-column gdlr-core-column-1">
                <div class="gdlr-core-course-search-field gdlr-core-course-field-course-id">
                    <div class="gdlr-core-course-form-combobox gdlr-core-skin-e-background">
                    	<select class="gdlr-core-skin-e-content" name="<?php echo $search_options; ?>">
                            <option value="" ><?php echo $tax_list[$search_options]; ?></option>
								<?php foreach( $terms as $term_slug => $term_name ) : ?>
            					<option value="<?php echo $term_slug ?>"><?php echo $term_name; ?></option>
            					<?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

 			<?php } ?>
             <?php endforeach; ?>
                 <div class="gdlr-core-course-form-submit gdlr-core-course-column gdlr-core-column-first gdlr-core-center-align"><input class="gdlr-core-full-size" type="submit" value="Search"></div>
        </form>
    </div>
</div>
</div><!-- end search mobile -->

	<div class="gdlr-core-course-search-page-container gdlr-core-container clearfix">
		<div class="gdlr-core-course-search-page-content-wrap gdlr-core-column-40" >
			<div class="gdlr-core-course-search-page-content" >
			<?php
				$atts = array(
					'num-fetch' => empty($settings['num-fetch'])? 9: $settings['num-fetch'],
					'orderby' => 'date',
					'order' => 'desc',
					'course-style' => 'list-info',
					'course-info' => empty($settings['course-info'])? array(): $settings['course-info'],
					'padding-bottom' => '0px',
					'pagination' => 'page',
					'keywords' => empty($_GET['course-keywords'])? '': $_GET['course-keywords'],
					'course-id' => empty($_GET['course-id'])? '': $_GET['course-id']
				);

				// taxonomy
				$tax_fields = array( 
					'course_category' => esc_html__('Category', 'tourmaster'),
					'course_tag' => esc_html__('Tag', 'tourmaster') 
				);
				$tax_fields = $tax_fields + goodlayers_core_course_get_custom_tax_list();
				foreach( $tax_fields as $tax_field => $tax_title ){
					if( !empty($_GET[$tax_field]) ){
						$atts[$tax_field] = $_GET[$tax_field];
					}
				}

				echo gdlr_core_pb_element_course::get_content($atts);
			?>
			</div>
		</div>
		<div class="gdlr-core-column-20" >
			<div class="gdlr-core-course-search-page-sidebar" >
			<?php
				$atts = array(
					'title' => esc_html__('Search For Courses', 'goodlayers-core-course'),
					'search-fields' => empty($settings['search-fields'])? array('keywords', 'course-id', 'course_category', 'course_tag'): $settings['search-fields'],
					'with-frame' => 'enable',
					'title-color' => empty($settings['title-color'])? '': $settings['title-color'],
					'frame-background' => empty($settings['frame-background'])? '': $settings['frame-background'],
					'column' => 1
				);


				echo gdlr_core_pb_element_course_search::get_content($atts);
			?>
			</div>
		</div>
	</div>
</div>
<?php
		}
	}

	add_action('goodlayers_core_course_archive_content', 'goodlayers_core_course_archive_content', 10, 1);
	if( !function_exists('goodlayers_core_course_archive_content') ){
		function goodlayers_core_course_archive_content( $settings ){
?>
<div class="gdlr-core-course-archive-page" >
	<div class="gdlr-core-course-archive-page-container gdlr-core-container clearfix">
		<div class="gdlr-core-course-archive-page-content-wrap gdlr-core-column-40" >
			<div class="gdlr-core-course-archive-page-content" >
			<?php
				global $wp_query;
				$atts = array(
					'num-fetch' => empty($settings['num-fetch'])? 9: $settings['num-fetch'],
					'course-style' => 'list-info',
					'course-info' => empty($settings['course-info'])? array(): $settings['course-info'],
					'padding-bottom' => '0px',
					'pagination' => 'page',
					'query' => $wp_query
				);

				echo gdlr_core_pb_element_course::get_content($atts);
			?>
			</div>
		</div>
		<div class="gdlr-core-column-20" >
			<div class="gdlr-core-course-archive-page-sidebar" >
			<?php
				$atts = array(
					'title' => esc_html__('Search For Courses', 'goodlayers-core-course'),
					'search-fields' => empty($settings['search-fields'])? array('keywords', 'course-id', 'course_category', 'course_tag'): $settings['search-fields'],
					'with-frame' => 'enable',
					'title-color' => empty($settings['title-color'])? '': $settings['title-color'],
					'frame-background' => empty($settings['frame-background'])? '': $settings['frame-background'],
					'column' => 1
				);
				echo gdlr_core_pb_element_course_search::get_content($atts);
			?>
			</div>
		</div>
	</div>
</div>
<?php
		}
	}