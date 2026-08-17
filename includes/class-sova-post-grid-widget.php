<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

class Sova_Post_Grid_Widget extends Widget_Base {
	public function get_name() {
		return 'sova-professional-post-grid';
	}

	public function get_title() {
		return esc_html__( 'Sova Post Grid', 'sova-post-grid' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_keywords() {
		return array( 'posts', 'blog', 'grid', 'news', 'sova' );
	}

	public function get_style_depends() {
		return array( 'sova-post-grid' );
	}

	protected function register_controls() {
		$this->register_header_controls();
		$this->register_query_controls();
		$this->register_card_content_controls();
		$this->register_layout_controls();
		$this->register_header_style_controls();
		$this->register_card_style_controls();
		$this->register_content_style_controls();
	}

	private function register_header_controls() {
		$this->start_controls_section( 'section_header', array( 'label' => esc_html__( 'Headline', 'sova-post-grid' ) ) );

		$this->add_control( 'show_header', array(
			'label' => esc_html__( 'Show Headline', 'sova-post-grid' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'sova-post-grid' ),
			'label_off' => esc_html__( 'Hide', 'sova-post-grid' ),
			'return_value' => 'yes',
			'default' => 'yes',
		) );
		$this->add_control( 'headline', array(
			'label' => esc_html__( 'Title', 'sova-post-grid' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( 'Latest Articles', 'sova-post-grid' ),
			'label_block' => true,
			'condition' => array( 'show_header' => 'yes' ),
		) );
		$this->add_control( 'headline_tag', array(
			'label' => esc_html__( 'Title HTML Tag', 'sova-post-grid' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'h2',
			'options' => array( 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6', 'div' => 'div' ),
			'condition' => array( 'show_header' => 'yes' ),
		) );
		$this->add_control( 'subtitle', array(
			'label' => esc_html__( 'Subtitle', 'sova-post-grid' ),
			'type' => Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Discover our latest news, guides, and insights.', 'sova-post-grid' ),
			'rows' => 3,
			'condition' => array( 'show_header' => 'yes' ),
		) );
		$this->add_control( 'view_more_text', array(
			'label' => esc_html__( 'View More Text', 'sova-post-grid' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( 'View All Posts', 'sova-post-grid' ),
			'label_block' => true,
			'condition' => array( 'show_header' => 'yes' ),
		) );
		$this->add_control( 'view_more_url', array(
			'label' => esc_html__( 'View More Link', 'sova-post-grid' ),
			'type' => Controls_Manager::URL,
			'placeholder' => 'https://example.com/blog/',
			'dynamic' => array( 'active' => true ),
			'condition' => array( 'show_header' => 'yes' ),
		) );
		$this->add_control( 'view_more_icon', array(
			'label' => esc_html__( 'View More Icon', 'sova-post-grid' ),
			'type' => Controls_Manager::ICONS,
			'default' => array( 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ),
			'condition' => array( 'show_header' => 'yes' ),
		) );
		$this->add_control( 'show_divider', array(
			'label' => esc_html__( 'Show Divider', 'sova-post-grid' ),
			'type' => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default' => 'yes',
			'condition' => array( 'show_header' => 'yes' ),
		) );
		$this->end_controls_section();
	}

	private function register_query_controls() {
		$categories = array();
		foreach ( get_categories( array( 'hide_empty' => false ) ) as $category ) {
			$categories[ $category->term_id ] = $category->name;
		}

		$this->start_controls_section( 'section_query', array( 'label' => esc_html__( 'Post Query', 'sova-post-grid' ) ) );
		$this->add_control( 'posts_per_page', array(
			'label' => esc_html__( 'Posts to Show', 'sova-post-grid' ),
			'type' => Controls_Manager::NUMBER,
			'default' => 6,
			'min' => 1,
			'max' => 50,
		) );
		$this->add_control( 'categories', array(
			'label' => esc_html__( 'Include Categories', 'sova-post-grid' ),
			'type' => Controls_Manager::SELECT2,
			'multiple' => true,
			'options' => $categories,
			'label_block' => true,
		) );
		$this->add_control( 'exclude_categories', array(
			'label' => esc_html__( 'Exclude Categories', 'sova-post-grid' ),
			'type' => Controls_Manager::SELECT2,
			'multiple' => true,
			'options' => $categories,
			'label_block' => true,
		) );
		$this->add_control( 'orderby', array(
			'label' => esc_html__( 'Order By', 'sova-post-grid' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'date',
			'options' => array(
				'date' => esc_html__( 'Date', 'sova-post-grid' ),
				'title' => esc_html__( 'Title', 'sova-post-grid' ),
				'menu_order' => esc_html__( 'Menu Order', 'sova-post-grid' ),
				'modified' => esc_html__( 'Modified Date', 'sova-post-grid' ),
				'rand' => esc_html__( 'Random', 'sova-post-grid' ),
				'comment_count' => esc_html__( 'Comment Count', 'sova-post-grid' ),
			),
		) );
		$this->add_control( 'order', array(
			'label' => esc_html__( 'Order', 'sova-post-grid' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'DESC',
			'options' => array( 'DESC' => esc_html__( 'Descending', 'sova-post-grid' ), 'ASC' => esc_html__( 'Ascending', 'sova-post-grid' ) ),
		) );
		$this->add_control( 'offset', array(
			'label' => esc_html__( 'Offset', 'sova-post-grid' ),
			'type' => Controls_Manager::NUMBER,
			'default' => 0,
			'min' => 0,
		) );
		$this->add_control( 'exclude_current', array(
			'label' => esc_html__( 'Exclude Current Post', 'sova-post-grid' ),
			'type' => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default' => 'yes',
		) );
		$this->end_controls_section();
	}

	private function register_card_content_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => esc_html__( 'Post Content', 'sova-post-grid' ) ) );
		$this->add_control( 'show_image', array( 'label' => esc_html__( 'Show Thumbnail', 'sova-post-grid' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_group_control( Group_Control_Image_Size::get_type(), array( 'name' => 'thumbnail', 'default' => 'large', 'condition' => array( 'show_image' => 'yes' ) ) );
		$this->add_control( 'show_date', array( 'label' => esc_html__( 'Show Date', 'sova-post-grid' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'date_format', array( 'label' => esc_html__( 'Date Format', 'sova-post-grid' ), 'type' => Controls_Manager::TEXT, 'default' => 'F j, Y', 'description' => esc_html__( 'Uses the WordPress date format.', 'sova-post-grid' ), 'condition' => array( 'show_date' => 'yes' ) ) );
		$this->add_control( 'show_excerpt', array( 'label' => esc_html__( 'Show Description', 'sova-post-grid' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'excerpt_length', array( 'label' => esc_html__( 'Description Length (Words)', 'sova-post-grid' ), 'type' => Controls_Manager::NUMBER, 'default' => 22, 'min' => 1, 'max' => 200, 'condition' => array( 'show_excerpt' => 'yes' ) ) );
		$this->add_control( 'excerpt_suffix', array( 'label' => esc_html__( 'Description Suffix', 'sova-post-grid' ), 'type' => Controls_Manager::TEXT, 'default' => '…', 'condition' => array( 'show_excerpt' => 'yes' ) ) );
		$this->add_control( 'title_tag', array( 'label' => esc_html__( 'Post Title HTML Tag', 'sova-post-grid' ), 'type' => Controls_Manager::SELECT, 'default' => 'h3', 'options' => array( 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6', 'div' => 'div' ) ) );
		$this->add_control( 'open_new_tab', array( 'label' => esc_html__( 'Open Posts in New Tab', 'sova-post-grid' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes' ) );
		$this->end_controls_section();
	}

	private function register_layout_controls() {
		$this->start_controls_section( 'section_layout', array( 'label' => esc_html__( 'Grid Layout', 'sova-post-grid' ) ) );
		$this->add_responsive_control( 'columns', array(
			'label' => esc_html__( 'Columns', 'sova-post-grid' ),
			'type' => Controls_Manager::SELECT,
			'desktop_default' => '3', 'tablet_default' => '2', 'mobile_default' => '1',
			'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ),
			'selectors' => array( '{{WRAPPER}} .sova-post-grid__items' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ),
		) );
		$this->add_responsive_control( 'column_gap', array(
			'label' => esc_html__( 'Column Gap', 'sova-post-grid' ), 'type' => Controls_Manager::SLIDER,
			'size_units' => array( 'px', 'em', 'rem' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ),
			'default' => array( 'size' => 24, 'unit' => 'px' ),
			'selectors' => array( '{{WRAPPER}} .sova-post-grid__items' => 'column-gap: {{SIZE}}{{UNIT}};' ),
		) );
		$this->add_responsive_control( 'row_gap', array(
			'label' => esc_html__( 'Row Gap', 'sova-post-grid' ), 'type' => Controls_Manager::SLIDER,
			'size_units' => array( 'px', 'em', 'rem' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ),
			'default' => array( 'size' => 24, 'unit' => 'px' ),
			'selectors' => array( '{{WRAPPER}} .sova-post-grid__items' => 'row-gap: {{SIZE}}{{UNIT}};' ),
		) );
		$this->add_responsive_control( 'text_align', array(
			'label' => esc_html__( 'Card Alignment', 'sova-post-grid' ), 'type' => Controls_Manager::CHOOSE, 'default' => 'left',
			'options' => array(
				'left' => array( 'title' => esc_html__( 'Left', 'sova-post-grid' ), 'icon' => 'eicon-text-align-left' ),
				'center' => array( 'title' => esc_html__( 'Center', 'sova-post-grid' ), 'icon' => 'eicon-text-align-center' ),
				'right' => array( 'title' => esc_html__( 'Right', 'sova-post-grid' ), 'icon' => 'eicon-text-align-right' ),
			),
			'selectors' => array( '{{WRAPPER}} .sova-post-grid__content' => 'text-align: {{VALUE}};' ),
		) );
		$this->end_controls_section();
	}

	private function register_header_style_controls() {
		$this->start_controls_section( 'section_header_style', array( 'label' => esc_html__( 'Headline Style', 'sova-post-grid' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'headline_color', array( 'label' => esc_html__( 'Title Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#08B4D4', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__headline' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'headline_typography', 'selector' => '{{WRAPPER}} .sova-post-grid__headline' ) );
		$this->add_control( 'subtitle_color', array( 'label' => esc_html__( 'Subtitle Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#20242A', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__subtitle' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'subtitle_typography', 'selector' => '{{WRAPPER}} .sova-post-grid__subtitle' ) );
		$this->add_control( 'link_color', array( 'label' => esc_html__( 'View More Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#08B4D4', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__more' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'link_hover_color', array( 'label' => esc_html__( 'View More Hover Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#087D9A', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__more:hover' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'link_typography', 'selector' => '{{WRAPPER}} .sova-post-grid__more' ) );
		$this->add_responsive_control( 'header_bottom_space', array( 'label' => esc_html__( 'Header Bottom Spacing', 'sova-post-grid' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 30 ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__header' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'divider_color', array( 'label' => esc_html__( 'Divider Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#D7DEE8', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__header--divider' => 'border-bottom-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'divider_space', array( 'label' => esc_html__( 'Divider Spacing', 'sova-post-grid' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 28 ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__header--divider' => 'padding-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_card_style_controls() {
		$this->start_controls_section( 'section_card_style', array( 'label' => esc_html__( 'Card & Image Style', 'sova-post-grid' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_group_control( Group_Control_Background::get_type(), array( 'name' => 'card_background', 'types' => array( 'classic', 'gradient' ), 'selector' => '{{WRAPPER}} .sova-post-grid__card' ) );
		$this->add_group_control( Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .sova-post-grid__card', 'fields_options' => array( 'border' => array( 'default' => 'solid' ), 'width' => array( 'default' => array( 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ) ), 'color' => array( 'default' => '#D7DEE8' ) ) ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Border Radius', 'sova-post-grid' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'default' => array( 'top' => 5, 'right' => 5, 'bottom' => 5, 'left' => 5, 'unit' => 'px', 'isLinked' => true ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .sova-post-grid__card' ) );
		$this->add_responsive_control( 'content_padding', array( 'label' => esc_html__( 'Content Padding', 'sova-post-grid' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'default' => array( 'top' => 20, 'right' => 20, 'bottom' => 22, 'left' => 20, 'unit' => 'px', 'isLinked' => false ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'image_ratio', array( 'label' => esc_html__( 'Image Aspect Ratio', 'sova-post-grid' ), 'type' => Controls_Manager::SELECT, 'default' => '16/10', 'options' => array( '1/1' => '1:1', '4/3' => '4:3', '3/2' => '3:2', '16/9' => '16:9', '16/10' => '16:10', '21/9' => '21:9' ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__image' => 'aspect-ratio: {{VALUE}};' ) ) );
		$this->add_control( 'image_fit', array( 'label' => esc_html__( 'Image Fit', 'sova-post-grid' ), 'type' => Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => esc_html__( 'Cover', 'sova-post-grid' ), 'contain' => esc_html__( 'Contain', 'sova-post-grid' ) ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__image img' => 'object-fit: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Css_Filter::get_type(), array( 'name' => 'image_filters', 'selector' => '{{WRAPPER}} .sova-post-grid__image img' ) );
		$this->add_control( 'hover_heading', array( 'label' => esc_html__( 'Hover', 'sova-post-grid' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'card_hover_border_color', array( 'label' => esc_html__( 'Border Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#08B4D4', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__card:hover' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 'image_hover_scale', array( 'label' => esc_html__( 'Image Zoom', 'sova-post-grid' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 1.3, 'step' => 0.01 ) ), 'default' => array( 'size' => 1.04 ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__card:hover .sova-post-grid__image img' => 'transform: scale({{SIZE}});' ) ) );
		$this->end_controls_section();
	}

	private function register_content_style_controls() {
		$this->start_controls_section( 'section_content_style', array( 'label' => esc_html__( 'Post Content Style', 'sova-post-grid' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'date_color', array( 'label' => esc_html__( 'Date Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#7D8AA2', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__date' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'date_typography', 'selector' => '{{WRAPPER}} .sova-post-grid__date' ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#365A9D', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__title a' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'title_hover_color', array( 'label' => esc_html__( 'Title Hover Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#08B4D4', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__title a:hover' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .sova-post-grid__title' ) );
		$this->add_control( 'excerpt_color', array( 'label' => esc_html__( 'Description Color', 'sova-post-grid' ), 'type' => Controls_Manager::COLOR, 'default' => '#596579', 'selectors' => array( '{{WRAPPER}} .sova-post-grid__excerpt' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'excerpt_typography', 'selector' => '{{WRAPPER}} .sova-post-grid__excerpt' ) );
		$this->add_responsive_control( 'date_spacing', array( 'label' => esc_html__( 'Date Bottom Spacing', 'sova-post-grid' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'default' => array( 'size' => 8 ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__date' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'title_spacing', array( 'label' => esc_html__( 'Title Bottom Spacing', 'sova-post-grid' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'default' => array( 'size' => 10 ), 'selectors' => array( '{{WRAPPER}} .sova-post-grid__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$query_args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => max( 1, (int) $settings['posts_per_page'] ),
			'orderby' => sanitize_key( $settings['orderby'] ),
			'order' => 'ASC' === $settings['order'] ? 'ASC' : 'DESC',
			'offset' => max( 0, (int) $settings['offset'] ),
			'ignore_sticky_posts' => true,
			'no_found_rows' => true,
		);

		if ( ! empty( $settings['categories'] ) ) {
			$query_args['category__in'] = array_map( 'absint', $settings['categories'] );
		}
		if ( ! empty( $settings['exclude_categories'] ) ) {
			$query_args['category__not_in'] = array_map( 'absint', $settings['exclude_categories'] );
		}
		if ( 'yes' === $settings['exclude_current'] && is_singular( 'post' ) ) {
			$query_args['post__not_in'] = array( get_queried_object_id() );
		}

		$query = new WP_Query( apply_filters( 'sova_post_grid_query_args', $query_args, $settings, $this ) );
		?>
		<section class="sova-post-grid" aria-label="<?php echo esc_attr( $settings['headline'] ?: __( 'Blog posts', 'sova-post-grid' ) ); ?>">
			<?php $this->render_header( $settings ); ?>
			<?php if ( $query->have_posts() ) : ?>
				<div class="sova-post-grid__items">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php $this->render_card( $settings ); ?>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<p class="sova-post-grid__empty"><?php echo esc_html__( 'No posts found.', 'sova-post-grid' ); ?></p>
			<?php endif; ?>
		</section>
		<?php
		wp_reset_postdata();
	}

	private function render_header( $settings ) {
		if ( 'yes' !== $settings['show_header'] ) {
			return;
		}
		$header_class = 'sova-post-grid__header';
		if ( 'yes' === $settings['show_divider'] ) {
			$header_class .= ' sova-post-grid__header--divider';
		}
		?>
		<div class="<?php echo esc_attr( $header_class ); ?>">
			<div class="sova-post-grid__heading-copy">
				<?php if ( $settings['headline'] ) :
					$tag = in_array( $settings['headline_tag'], array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div' ), true ) ? $settings['headline_tag'] : 'h2'; ?>
					<<?php echo esc_html( $tag ); ?> class="sova-post-grid__headline"><?php echo esc_html( $settings['headline'] ); ?></<?php echo esc_html( $tag ); ?>>
				<?php endif; ?>
				<?php if ( $settings['subtitle'] ) : ?><div class="sova-post-grid__subtitle"><?php echo wp_kses_post( nl2br( $settings['subtitle'] ) ); ?></div><?php endif; ?>
			</div>
			<?php if ( $settings['view_more_text'] && ! empty( $settings['view_more_url']['url'] ) ) :
				$this->add_link_attributes( 'view_more', $settings['view_more_url'] ); ?>
				<a class="sova-post-grid__more" <?php $this->print_render_attribute_string( 'view_more' ); ?>>
					<span><?php echo esc_html( $settings['view_more_text'] ); ?></span>
					<?php Icons_Manager::render_icon( $settings['view_more_icon'], array( 'aria-hidden' => 'true' ) ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}

	private function render_card( $settings ) {
		$permalink = get_permalink();
		$link_attrs = ' href="' . esc_url( $permalink ) . '"';
		if ( 'yes' === $settings['open_new_tab'] ) {
			$link_attrs .= ' target="_blank" rel="noopener noreferrer"';
		}
		$title_tag = in_array( $settings['title_tag'], array( 'h2', 'h3', 'h4', 'h5', 'h6', 'div' ), true ) ? $settings['title_tag'] : 'h3';
		$excerpt = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( strip_shortcodes( get_the_content() ) );
		$image_size = ! empty( $settings['thumbnail_size'] ) ? $settings['thumbnail_size'] : 'large';
		if ( 'custom' === $image_size && ! empty( $settings['thumbnail_custom_dimension']['width'] ) && ! empty( $settings['thumbnail_custom_dimension']['height'] ) ) {
			$image_size = array(
				absint( $settings['thumbnail_custom_dimension']['width'] ),
				absint( $settings['thumbnail_custom_dimension']['height'] ),
			);
		}
		?>
		<article <?php post_class( 'sova-post-grid__card' ); ?>>
			<?php if ( 'yes' === $settings['show_image'] && has_post_thumbnail() ) : ?>
				<a class="sova-post-grid__image"<?php echo $link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr( get_the_title() ); ?>">
					<?php echo get_the_post_thumbnail( get_the_ID(), $image_size, array( 'loading' => 'lazy', 'decoding' => 'async' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			<?php endif; ?>
			<div class="sova-post-grid__content">
				<?php if ( 'yes' === $settings['show_date'] ) : ?>
					<time class="sova-post-grid__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( $settings['date_format'] ) ); ?></time>
				<?php endif; ?>
				<<?php echo esc_html( $title_tag ); ?> class="sova-post-grid__title"><a<?php echo $link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( get_the_title() ); ?></a></<?php echo esc_html( $title_tag ); ?>>
				<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
					<div class="sova-post-grid__excerpt"><?php echo esc_html( wp_trim_words( $excerpt, max( 1, (int) $settings['excerpt_length'] ), $settings['excerpt_suffix'] ) ); ?></div>
				<?php endif; ?>
			</div>
		</article>
		<?php
	}
}
