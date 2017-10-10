<?php

	class ACP_Column_Assigned_Products extends AC_Column_Assigned_Products
		implements ACP_Column_FilteringInterface {

		public function filtering() {
			return new ACP_Filtering_Model_Assigned_Products( $this );
		}
	}

	/**
	 * Filtering class.
	 */
	class ACP_Filtering_Model_Assigned_Products extends ACP_Filtering_Model {

		public function get_filtering_vars( $vars ) {

			add_filter( 'posts_where', function ( $where ) {
				$where = str_replace( "meta_key = 'kg_order_items_%", "meta_key LIKE 'kg_order_items_%", $where );

				return $where;
			} );

			$product_id = $this->get_filter_value();

			$vars[ 'meta_query' ][] = [
				'key'     => 'kg_order_items_%_kg_order_item',
				'compare' => '=',
				'value'   => $product_id,
			];

			return $vars;
		}

		public function get_filtering_data() {
			return [
				'order'        => 'label',
				'empty_option' => false,
				'options'      => $this->get_products_for_dropdown(),
			];
		}

		private function get_products_for_dropdown() {
			$args           = [
				'posts_per_page' => -1,
				'post_type'      => 'product',
			];
			$products_query = new \WP_Query( $args );
			$data           = [];

			if ( $products_query->have_posts() ) {
				while ( $products_query->have_posts() ) {
					$products_query->the_post();
					$data[ $products_query->post->ID ] = $products_query->post->post_title;
				}
				wp_reset_postdata();
			}

			return $data;
		}
	}