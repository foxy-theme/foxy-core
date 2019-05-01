<?php
/**
 * WordPress has define meta to extends Post infos and User info
 * Foxy will use meta info in a different way
 *
 * @package Foxy/Core
 * @author Puleeno Nguyen <puleeno@gmail.com>
 * @link https://wpclouds.com
 */

namespace Jankx\Core\Traits;
/**
 * Meta trait
 */
trait Meta {
	/**
	 * WordPress Meta Framework integrate with Foxy theme framework
	 *
	 * @var instaceof Meta_Base
	 */
	protected $meta_framework;

	/**
	 * Set Meta Framework for Foxy
	 *
	 * @param Meta_Framework_Base $framework Foxy UI framework.
	 * @throws \Exception Throw exception if $framework is not be instance of UI_Framework_Base.
	 * @return void
	 */
	public function set_meta_framework( $framework ) {
		if ( ! ( $framework instanceof Meta_Framework_Base ) ) {
			throw new \Exception(
				sprintf( 'Meta Framework must be instance of %s class', 'Meta_Framework_Base' ),
				333
			);
		}
		$this->meta_framework = $framework;

		/**
		 * Create UI Closure for Foxy
		 */
		$this->meta = function() {
			return $this->meta_framework;
		};
	}

	/**
	 * Get meta value via meta framework
	 * Every meta framework has different method to get meta value
	 * So Foxy framework must integrate with meta framework is used
	 *
	 * @param string $meta_key Meta key need to get value.
	 * @param int    $post_id  Post or User ID need to get meta value.
	 * @param bool   $single   Return value type is single if true or not return array.
	 *
	 * @return string
	 */
	public static function get_meta( $meta_key, $post_id = null, $single = true ) {
		return get_metadata(
			'post',
			get_object_id( $post_id, WP_Post::class ),
			$meta_key,
			$single
		);
	}

	public static function set_meta( $post_id, $meta_key, $value ) {
		return call_user_func(
			array( self::instance()->meta_framework, 'set' ),
			$post_id,
			$meta_key,
			$value
		);
	}

	/**
	 * Get user meta from WordPress user meta
	 *
	 * @param string $meta_key Meta key need to get meta value.
	 * @param int    $user_id  User ID need to get meta value.
	 * @param bool   $single   Return value type is single if true or not return array.
	 *
	 * @return string
	 */
	public static function user_meta( $meta_key, $user_id = null, $single = true ) {
		return get_metadata(
			'user',
			get_object_id( $user_id, WP_User::class ),
			$meta_key,
			$single
		);
	}

	public static function term_meta( $meta_key, $term_id, $single = true ) {
		return get_metadata(
			'term',
			get_object_id( $term_id, WP_Term::class ),
			$meta_key,
			$single
		);
	}
}