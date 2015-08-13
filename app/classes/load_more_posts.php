<?php
class Load_More_Posts {
	private $args;
	private $postQ;
	private $count;
	private $argv;

	public function __construct( $argv ) {
		if (isset($argv) && !empty($argv)) {
			$this->$argv = $argv;
			$this->getArgs();
			$this->render200();

		} else {
			$this->render404();
		}
	}

	private function getArgs() {
		$args = array( 	'post__not_in' => get_option('sticky_posts'), 
						'posts_per_page' => 5
				);
		if ( isset( $this->$argv['tag'])  && $this->$argv['tag'] !== "" ) {
			$args['tag'] = $this->$argv['tag'];
		}

		if ( isset( $this->$argv['category_name'] ) && $this->$argv['category_name'] !== "" ) {
			$args['category_name'] = $this->$argv['category_name'];
		}

		if ( isset($this->$argv['author_name']) && $this->$argv['author_name'] !== "") {
			$args['author_name'] = $this->$argv['author_name'];
		}

		if ( isset($this->$argv['exclude_ids']) ) {
			$ids = $this->$argv['exclude_ids'];
			$args['post__not_in'] = explode(",",$this->$argv['exclude_ids']);
		}

		$this->args = $args;
	}

	private function processPosts() {

		$postsQ = query_posts( $args );
		$count = count($postsQ);


		$posts = array();
		while(have_posts()): the_post();
			$cat_urls = array();
			foreach (get_the_category($post->ID) as $catObj) {
				array_push($cat_urls, get_category_link($catObj->term_id));
			}

			$tag_urls = array();
			foreach (get_the_tags() as $tagObj) {
				array_push($tag_urls, get_tag_link($tagObj->term_id));
			}

			array_push($posts, array(
				'post_id'		=> $post->ID,
				'title' 	=> get_the_title(),
				'tags'		=> get_the_tags(),
				'tag_urls' 	=> $tag_urls,	
				'cats'		=> get_the_category($post->ID),
				'cat_urls' 	=> $cat_urls,	
				'thumbnail'	=> wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0],
				'author'	=> get_the_author_meta('first_name'),
				'author_link' => get_author_posts_url( get_the_author_meta( 'ID' ) ),
				'excerpt'	=> get_the_excerpt(),
				'read_more'	=> esc_attr( get_post_meta( $post->ID, 'custom_read_more', true ) ),
				'permalink'	=> get_permalink()

				));
		endwhile;

		$return = array(
					'status'		=> 200,
					'post_count'	=> $count,
					'posts'			=> $posts
			);

		wp_send_json($return);
	}

	private function render404() {
		header('HTTP/1.1 401 Unauthorized', true, 401);
	}

	private function render200() {
        header("HTTP/1.1 200 OK", true, 200);
	}
}


//bootstrap WP
require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

new Load_More_Posts($_GET);

?>