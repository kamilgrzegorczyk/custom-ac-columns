<?php

	class AC_Column_Assigned_Products extends AC_Column {

		public function __construct() {

			// Identifier, pick an unique name. Single word, no spaces. Underscores allowed.
			$this->set_type( 'column-assigned-products' );

			// Default column label.
			$this->set_label( __( 'Assigned products', 'ac-assigned-products' ) );
		}

		/**
		 * Returns the display value for the column.
		 *
		 * @param int $post_id ID
		 * @return string Value
		 */
		public function get_value( $post_id ) {

			// get raw value
			$products = $this->get_raw_value( $post_id );

			$data = [];

			if ( ! empty( $products ) ) {
				foreach ( $products as $product ) {
					$data[] = '<a href="' . esc_url( get_edit_post_link( $product[ 'id' ] ) ) . '">' . $product[ 'title' ] . '</a>';
				}
			}

			return implode( ',<br>', $data );
		}

		/**
		 * Get the raw, underlying value for the column
		 * Not suitable for direct display, use get_value() for that
		 * This value will be used by 'inline-edit' and get_value().
		 *
		 * @param int $post_id ID
		 * @return mixed Value
		 */
		public function get_raw_value( $post_id ) {

			$products = get_field( 'kg_order_items', $post_id );
			$data     = [];

			if ( ! empty( $products ) ) {
				foreach ( $products as $product ) {
					$data[] = [
						'id'    => $product[ 'kg_order_item' ]->ID,
						'title' => $product[ 'kg_order_item' ]->post_title,
					];
				}
			}

			return $data;
		}

	}