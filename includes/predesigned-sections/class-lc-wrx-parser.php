<?php
if ( ! class_exists( 'LCPS_WRX_parser' ) ) {
	class LCPS_WRX_parser {

		var $processed_posts = array();
		var $posts = array();
		var $fetch_attachments = false;

		public function parse( $file ) {
			// Attempt to use proper XML parsers first
			if ( extension_loaded( 'simplexml' ) ) {
				$parser = new PS_WXR_Parser_SimpleXML;
				$result = $parser->parse( $file );

				// If SimpleXML succeeds or this is an invalid WXR file then return the results
				if ( ! is_wp_error( $result ) || 'SimpleXML_parse_error' != $result->get_error_code() ) {
					return $result;
				}
			} elseif ( extension_loaded( 'xml' ) ) {
				$parser = new PS_WXR_Parser_XML;
				$result = $parser->parse( $file );

				// If XMLParser succeeds or this is an invalid WXR file then return the results
				if ( ! is_wp_error( $result ) || 'XML_parse_error' != $result->get_error_code() ) {
					return $result;
				}
			} else {
				// use regular expressions if nothing else available or this is bad XML
				$parser = new PS_WXR_Parser_Regex;
				return $parser->parse( $file );
			}

			// We have a malformed XML file, so display the error and fallthrough to regex
			if ( isset( $result ) && defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG ) {
				echo '<pre>';
				if ( 'SimpleXML_parse_error' == $result->get_error_code() ) {
					foreach ( $result->get_error_data() as $error ) {
						echo $error->line . ':' . $error->column . ' ' . esc_html( $error->message ) . "\n";
					}
				} elseif ( 'XML_parse_error' == $result->get_error_code() ) {
					$error = $result->get_error_data();
					echo $error[0] . ':' . $error[1] . ' ' . esc_html( $error[2] );
				}
				echo '</pre>';
				echo '<p><strong>' . __( 'There was an error when reading this WXR file' ) . '</strong><br />';
				echo __( 'Details are shown above. The importer will now try again with a different parser...' ) . '</p>';
			}
		}

		/**
		 * Create new posts based on import information
		 *
		 * Posts marked as having a parent which doesn't exist will become top level items.
		 * Doesn't create a new post if: the post type doesn't exist, the given post ID
		 * is already noted as imported or a post with the same title and date already exists.
		 * Note that new/updated terms, comments and meta are imported for the last of the above.
		 */
		public function process_posts() {
			$result = apply_filters( 'wp_import_posts', $this->posts );
			if ( is_array( $result ) && isset( $result['posts'] ) ) {
				$this->posts = $result['posts'];
			} else {
				// LCPS_Base::p( $result );
				// exit();
			}
			unset( $result );

			foreach ( $this->posts as $post ) {
				$post = apply_filters( 'wp_import_post_data_raw', $post );

				if ( ! post_type_exists( $post['post_type'] ) ) {
					printf( __( 'Failed to import &#8220;%1$s&#8221;: Invalid post type %2$s', 'wordpress-importer' ),
					esc_html( $post['post_title'] ), esc_html( $post['post_type'] ) );
					echo '<br />';
					do_action( 'wp_import_post_exists', $post );
					continue;
				}

				if ( isset( $this->processed_posts[ $post['post_id'] ] ) && ! empty( $post['post_id'] ) ) {
					continue;
				}

				if ( $post['status'] == 'auto-draft' ) {
					continue;
				}

				if ( 'nav_menu_item' == $post['post_type'] ) {
					$this->process_menu_item( $post );
					continue;
				}

				$post_type_object = get_post_type_object( $post['post_type'] );

				$post_exists = post_exists( $post['post_title'], '', $post['post_date'] );

				if ( $post_exists && get_post_type( $post_exists ) == $post['post_type'] ) {
					// printf( __('%s &#8220;%s&#8221; already exists.', 'wordpress-importer'), $post_type_object->labels->singular_name, esc_html($post['post_title']) );
					// echo '<br />';
					// Update post
					$update_post = array(
					'ID'          => $post_exists,
					'post_status' => 'publish',
					);
					// Update the post into the database
					wp_update_post( $update_post );

					$comment_post_ID = $post_id = $post_exists;
				} else {
					$post_parent = (int) $post['post_parent'];
					if ( $post_parent ) {
						// if we already know the parent, map it to the new local ID
						if ( isset( $this->processed_posts[ $post_parent ] ) ) {
							$post_parent = $this->processed_posts[ $post_parent ];
							// otherwise record the parent for later
						} else {
							$this->post_orphans[ intval( $post['post_id'] ) ] = $post_parent;
							$post_parent = 0;
						}
					}

					// map the post author
					$author = sanitize_user( $post['post_author'], true );
					if ( isset( $this->author_mapping[ $author ] ) ) {
						$author = $this->author_mapping[ $author ];
					} else { $author = (int) get_current_user_id();
					}

					$postdata = array(
					'import_id' => $post['post_id'],
					'post_author' => $author,
					'post_date' => $post['post_date'],
					'post_date_gmt' => $post['post_date_gmt'],
					'post_content' => $post['post_content'],
					'post_excerpt' => $post['post_excerpt'],
					'post_title' => $post['post_title'],
					'post_status' => $post['status'],
					'post_name' => $post['post_name'],
					'comment_status' => $post['comment_status'],
					'ping_status' => $post['ping_status'],
					'guid' => $post['guid'],
					'post_parent' => $post_parent,
					'menu_order' => $post['menu_order'],
					'post_type' => $post['post_type'],
					'post_password' => $post['post_password'],
					);

					$original_post_ID = $post['post_id'];
					$postdata = apply_filters( 'wp_import_post_data_processed', $postdata, $post );

					if ( 'attachment' == $postdata['post_type'] ) {
						$remote_url = ! empty( $post['attachment_url'] ) ? $post['attachment_url'] : $post['guid'];

						// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
						// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
						$postdata['upload_date'] = $post['post_date'];
						if ( isset( $post['postmeta'] ) ) {
							foreach ( $post['postmeta'] as $meta ) {
								if ( $meta['key'] == '_wp_attached_file' ) {
									if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) ) {
										$postdata['upload_date'] = $matches[0];
									}
									break;
								}
							}
						}

						$comment_post_ID = $post_id = $this->process_attachment( $postdata, $remote_url );
					} else {
						$comment_post_ID = $post_id = wp_insert_post( $postdata, true );
						do_action( 'wp_import_insert_post', $post_id, $original_post_ID, $postdata, $post );
					}

					if ( is_wp_error( $post_id ) ) {
						printf( __( 'Failed to import %1$s &#8220;%2$s&#8221;', 'wordpress-importer' ),
						$post_type_object->labels->singular_name, esc_html( $post['post_title'] ) );
						if ( defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG ) {
							echo ': ' . $post_id->get_error_message();
						}
						echo '<br />';
						continue;
					}

					if ( $post['is_sticky'] == 1 ) {
						stick_post( $post_id );
					}
				}// End if().

				// map pre-import ID to local ID
				$this->processed_posts[ intval( $post['post_id'] ) ] = (int) $post_id;

				if ( ! isset( $post['terms'] ) ) {
					$post['terms'] = array();
				}

				$post['terms'] = apply_filters( 'wp_import_post_terms', $post['terms'], $post_id, $post );

				// add categories, tags and other terms
				if ( ! empty( $post['terms'] ) ) {
					$terms_to_set = array();
					foreach ( $post['terms'] as $term ) {
						// back compat with WXR 1.0 map 'tag' to 'post_tag'
						$taxonomy = ( 'tag' == $term['domain'] ) ? 'post_tag' : $term['domain'];
						$term_exists = term_exists( $term['slug'], $taxonomy );
						$term_id = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
						if ( ! $term_id ) {
							$t = wp_insert_term( $term['name'], $taxonomy, array(
								'slug' => $term['slug'],
							) );
							if ( ! is_wp_error( $t ) ) {
								$term_id = $t['term_id'];
								do_action( 'wp_import_insert_term', $t, $term, $post_id, $post );
							} else {
								printf( __( 'Failed to import %1$s %2$s', 'wordpress-importer' ), esc_html( $taxonomy ), esc_html( $term['name'] ) );
								if ( defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG ) {
									echo ': ' . $t->get_error_message();
								}
								echo '<br />';
								do_action( 'wp_import_insert_term_failed', $t, $term, $post_id, $post );
								continue;
							}
						}
						$terms_to_set[ $taxonomy ][] = intval( $term_id );
					}

					foreach ( $terms_to_set as $tax => $ids ) {
						$tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
						do_action( 'wp_import_set_post_terms', $tt_ids, $ids, $tax, $post_id, $post );
					}
					unset( $post['terms'], $terms_to_set );
				}

				if ( ! isset( $post['comments'] ) ) {
					$post['comments'] = array();
				}

				$post['comments'] = apply_filters( 'wp_import_post_comments', $post['comments'], $post_id, $post );

				// add/update comments
				if ( ! empty( $post['comments'] ) ) {
					$num_comments = 0;
					$inserted_comments = array();
					foreach ( $post['comments'] as $comment ) {
						$comment_id	= $comment['comment_id'];
						$newcomments[ $comment_id ]['comment_post_ID']      = $comment_post_ID;
						$newcomments[ $comment_id ]['comment_author']       = $comment['comment_author'];
						$newcomments[ $comment_id ]['comment_author_email'] = $comment['comment_author_email'];
						$newcomments[ $comment_id ]['comment_author_IP']    = $comment['comment_author_IP'];
						$newcomments[ $comment_id ]['comment_author_url']   = $comment['comment_author_url'];
						$newcomments[ $comment_id ]['comment_date']         = $comment['comment_date'];
						$newcomments[ $comment_id ]['comment_date_gmt']     = $comment['comment_date_gmt'];
						$newcomments[ $comment_id ]['comment_content']      = $comment['comment_content'];
						$newcomments[ $comment_id ]['comment_approved']     = $comment['comment_approved'];
						$newcomments[ $comment_id ]['comment_type']         = $comment['comment_type'];
						$newcomments[ $comment_id ]['comment_parent'] 	  = $comment['comment_parent'];
						$newcomments[ $comment_id ]['commentmeta']          = isset( $comment['commentmeta'] ) ? $comment['commentmeta'] : array();
						if ( isset( $this->processed_authors[ $comment['comment_user_id'] ] ) ) {
							$newcomments[ $comment_id ]['user_id'] = $this->processed_authors[ $comment['comment_user_id'] ];
						}
					}
					ksort( $newcomments );

					foreach ( $newcomments as $key => $comment ) {
						// if this is a new post we can skip the comment_exists() check
						if ( ! $post_exists || ! comment_exists( $comment['comment_author'], $comment['comment_date'] ) ) {
							if ( isset( $inserted_comments[ $comment['comment_parent'] ] ) ) {
								$comment['comment_parent'] = $inserted_comments[ $comment['comment_parent'] ];
							}
							$comment = wp_filter_comment( $comment );
							$inserted_comments[ $key ] = wp_insert_comment( $comment );
							do_action( 'wp_import_insert_comment', $inserted_comments[ $key ], $comment, $comment_post_ID, $post );

							foreach ( $comment['commentmeta'] as $meta ) {
								$value = maybe_unserialize( $meta['value'] );
								add_comment_meta( $inserted_comments[ $key ], $meta['key'], $value );
							}

							$num_comments++;
						}
					}
					unset( $newcomments, $inserted_comments, $post['comments'] );
				}// End if().

				if ( ! isset( $post['postmeta'] ) ) {
					$post['postmeta'] = array();
				}

				$post['postmeta'] = apply_filters( 'wp_import_post_meta', $post['postmeta'], $post_id, $post );

				// add/update post meta
				if ( ! empty( $post['postmeta'] ) ) {
					foreach ( $post['postmeta'] as $meta ) {
						$key = apply_filters( 'import_post_meta_key', $meta['key'], $post_id, $post );
						$value = false;

						if ( '_edit_last' == $key ) {
							if ( isset( $this->processed_authors[ intval( $meta['value'] ) ] ) ) {
								$value = $this->processed_authors[ intval( $meta['value'] ) ];
							} else { $key = false;
							}
						}

						if ( $key ) {
							// export gets meta straight from the DB so could have a serialized string
							if ( ! $value ) {
								$value = maybe_unserialize( $meta['value'] );
							}

							add_post_meta( $post_id, $key, $value );
							do_action( 'import_post_meta', $post_id, $key, $value );

							// if the post has a featured image, take note of this in case of remap
							if ( '_thumbnail_id' == $key ) {
								$this->featured_images[ $post_id ] = (int) $value;
							}
						}
					}
				}
			}// End foreach().

			unset( $this->posts );
		}

		/**
		 * Attempt to create a new menu item from import data
		 *
		 * Fails for draft, orphaned menu items and those without an associated nav_menu
		 * or an invalid nav_menu term. If the post type or term object which the menu item
		 * represents doesn't exist then the menu item will not be imported (waits until the
		 * end of the import to retry again before discarding).
		 *
		 * @param array $item Menu item details from WXR file
		 */
		function process_menu_item( $item ) {
			// skip draft, orphaned menu items
			if ( 'draft' == $item['status'] ) {
				return;
			}

			$menu_slug = false;
			if ( isset( $item['terms'] ) ) {
				// loop through terms, assume first nav_menu term is correct menu
				foreach ( $item['terms'] as $term ) {
					if ( 'nav_menu' == $term['domain'] ) {
						$menu_slug = $term['slug'];
						break;
					}
				}
			}

			// no nav_menu term associated with this menu item
			if ( ! $menu_slug ) {
				_e( 'Menu item skipped due to missing menu slug', 'wordpress-importer' );
				echo '<br />';
				return;
			}

			$menu_id = term_exists( $menu_slug, 'nav_menu' );
			if ( ! $menu_id ) {
				printf( __( 'Menu item skipped due to invalid menu slug: %s', 'wordpress-importer' ), esc_html( $menu_slug ) );
				echo '<br />';
				return;
			} else {
				$menu_id = is_array( $menu_id ) ? $menu_id['term_id'] : $menu_id;
			}

			foreach ( $item['postmeta'] as $meta ) {
				$$meta['key'] = $meta['value'];
			}

			if ( 'taxonomy' == $_menu_item_type && isset( $this->processed_terms[ intval( $_menu_item_object_id ) ] ) ) {
				$_menu_item_object_id = $this->processed_terms[ intval( $_menu_item_object_id ) ];
			} elseif ( 'post_type' == $_menu_item_type && isset( $this->processed_posts[ intval( $_menu_item_object_id ) ] ) ) {
				$_menu_item_object_id = $this->processed_posts[ intval( $_menu_item_object_id ) ];
			} elseif ( 'custom' != $_menu_item_type ) {
				// associated object is missing or not imported yet, we'll retry later
				$this->missing_menu_items[] = $item;
				return;
			}

			if ( isset( $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ] ) ) {
				$_menu_item_menu_item_parent = $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ];
			} elseif ( $_menu_item_menu_item_parent ) {
				$this->menu_item_orphans[ intval( $item['post_id'] ) ] = (int) $_menu_item_menu_item_parent;
				$_menu_item_menu_item_parent = 0;
			}

			// wp_update_nav_menu_item expects CSS classes as a space separated string
			$_menu_item_classes = maybe_unserialize( $_menu_item_classes );
			if ( is_array( $_menu_item_classes ) ) {
				$_menu_item_classes = implode( ' ', $_menu_item_classes );
			}

			$args = array(
			'menu-item-object-id' => $_menu_item_object_id,
			'menu-item-object' => $_menu_item_object,
			'menu-item-parent-id' => $_menu_item_menu_item_parent,
			'menu-item-position' => intval( $item['menu_order'] ),
			'menu-item-type' => $_menu_item_type,
			'menu-item-title' => $item['post_title'],
			'menu-item-url' => $_menu_item_url,
			'menu-item-description' => $item['post_content'],
			'menu-item-attr-title' => $item['post_excerpt'],
			'menu-item-target' => $_menu_item_target,
			'menu-item-classes' => $_menu_item_classes,
			'menu-item-xfn' => $_menu_item_xfn,
			'menu-item-status' => $item['status'],
			);

			$id = wp_update_nav_menu_item( $menu_id, 0, $args );
			if ( $id && ! is_wp_error( $id ) ) {
				$this->processed_menu_items[ intval( $item['post_id'] ) ] = (int) $id;
			}
		}

		/**
		 * If fetching attachments is enabled then attempt to create a new attachment
		 *
		 * @param array  $post Attachment post details from WXR
		 * @param string $url URL to fetch attachment from
		 * @return int|WP_Error Post ID on success, WP_Error otherwise
		 */
		function process_attachment( $post, $url ) {
			if ( ! $this->fetch_attachments ) {
				return new WP_Error( 'attachment_processing_error',
				__( 'Fetching attachments is not enabled', 'wordpress-importer' ) );
			}

			// if the URL is absolute, but does not contain address, then upload it assuming base_site_url
			if ( preg_match( '|^/[\w\W]+$|', $url ) ) {
				$url = rtrim( $this->base_url, '/' ) . $url;
			}

			$upload = $this->fetch_remote_file( $url, $post );
			if ( is_wp_error( $upload ) ) {
				return $upload;
			}

			if ( $info = wp_check_filetype( $upload['file'] ) ) {
				$post['post_mime_type'] = $info['type'];
			} else { return new WP_Error( 'attachment_processing_error', __( 'Invalid file type', 'wordpress-importer' ) );
			}

			$post['guid'] = $upload['url'];

			// as per wp-admin/includes/upload.php
			$post_id = wp_insert_attachment( $post, $upload['file'] );
			wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

			// remap resized image URLs, works by stripping the extension and remapping the URL stub.
			if ( preg_match( '!^image/!', $info['type'] ) ) {
					$parts = pathinfo( $url );
					$name = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

					$parts_new = pathinfo( $upload['url'] );
					$name_new = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

					$this->url_remap[ $parts['dirname'] . '/' . $name ] = $parts_new['dirname'] . '/' . $name_new;
			}

			return $post_id;
		}
	}}// End if().


/**
 * WXR Parser that makes use of the SimpleXML PHP extension.
 */
if ( ! class_exists( 'PS_WXR_Parser_SimpleXML' ) ) {
	class PS_WXR_Parser_SimpleXML {
		function parse( $file ) {
			$authors = $posts = $categories = $tags = $terms = array();

			$internal_errors = libxml_use_internal_errors( true );

			$dom = new DOMDocument;
			$old_value = null;
			if ( function_exists( 'libxml_disable_entity_loader' ) ) {
				$old_value = libxml_disable_entity_loader( true );
			}
			$success = $dom->loadXML( file_get_contents( $file ) );
			if ( ! is_null( $old_value ) ) {
				libxml_disable_entity_loader( $old_value );
			}

			if ( ! $success || isset( $dom->doctype ) ) {
				return new WP_Error( 'SimpleXML_parse_error', __( 'There was an error when reading this WXR file', 'wordpress-importer' ), libxml_get_errors() );
			}

			$xml = simplexml_import_dom( $dom );
			unset( $dom );

			// halt if loading produces an error
			if ( ! $xml ) {
				return new WP_Error( 'SimpleXML_parse_error', __( 'There was an error when reading this WXR file', 'wordpress-importer' ), libxml_get_errors() );
			}

			$wxr_version = $xml->xpath( '/rss/channel/wp:wxr_version' );
			if ( ! $wxr_version ) {
				return new WP_Error( 'WXR_parse_error', __( 'This does not appear to be a WXR file, missing/invalid WXR version number', 'wordpress-importer' ) );
			}

			$wxr_version = (string) trim( $wxr_version[0] );
			// confirm that we are dealing with the correct file format
			if ( ! preg_match( '/^\d+\.\d+$/', $wxr_version ) ) {
				return new WP_Error( 'WXR_parse_error', __( 'This does not appear to be a WXR file, missing/invalid WXR version number', 'wordpress-importer' ) );
			}

			$base_url = $xml->xpath( '/rss/channel/wp:base_site_url' );
			$base_url = isset( $base_url[0] ) ? (string) trim( $base_url[0] ) : get_bloginfo( 'url' ) . '/';

			$namespaces = $xml->getDocNamespaces();
			if ( ! isset( $namespaces['wp'] ) ) {
				$namespaces['wp'] = 'http://wordpress.org/export/1.1/';
			}
			if ( ! isset( $namespaces['excerpt'] ) ) {
				$namespaces['excerpt'] = 'http://wordpress.org/export/1.1/excerpt/';
			}

			// grab authors
			foreach ( $xml->xpath( '/rss/channel/wp:author' ) as $author_arr ) {
				$a = $author_arr->children( $namespaces['wp'] );
				$login = (string) $a->author_login;
				$authors[ $login ] = array(
				'author_id' => (int) $a->author_id,
				'author_login' => $login,
				'author_email' => (string) $a->author_email,
				'author_display_name' => (string) $a->author_display_name,
				'author_first_name' => (string) $a->author_first_name,
				'author_last_name' => (string) $a->author_last_name,
				);
			}

			// grab cats, tags and terms
			foreach ( $xml->xpath( '/rss/channel/wp:category' ) as $term_arr ) {
				$t = $term_arr->children( $namespaces['wp'] );
				$categories[] = array(
				'term_id' => (int) $t->term_id,
				'category_nicename' => (string) $t->category_nicename,
				'category_parent' => (string) $t->category_parent,
				'cat_name' => (string) $t->cat_name,
				'category_description' => (string) $t->category_description,
				);
			}

			foreach ( $xml->xpath( '/rss/channel/wp:tag' ) as $term_arr ) {
				$t = $term_arr->children( $namespaces['wp'] );
				$tags[] = array(
				'term_id' => (int) $t->term_id,
				'tag_slug' => (string) $t->tag_slug,
				'tag_name' => (string) $t->tag_name,
				'tag_description' => (string) $t->tag_description,
				);
			}

			foreach ( $xml->xpath( '/rss/channel/wp:term' ) as $term_arr ) {
				$t = $term_arr->children( $namespaces['wp'] );
				$terms[] = array(
				'term_id' => (int) $t->term_id,
				'term_taxonomy' => (string) $t->term_taxonomy,
				'slug' => (string) $t->term_slug,
				'term_parent' => (string) $t->term_parent,
				'term_name' => (string) $t->term_name,
				'term_description' => (string) $t->term_description,
				);
			}

			// grab posts
			foreach ( $xml->channel->item as $item ) {
				$post = array(
				'post_title' => (string) $item->title,
				'guid' => (string) $item->guid,
				);

				$dc = $item->children( 'http://purl.org/dc/elements/1.1/' );
				$post['post_author'] = (string) $dc->creator;

				$content = $item->children( 'http://purl.org/rss/1.0/modules/content/' );
				$excerpt = $item->children( $namespaces['excerpt'] );
				$post['post_content'] = (string) $content->encoded;
				$post['post_excerpt'] = (string) $excerpt->encoded;

				$wp = $item->children( $namespaces['wp'] );
				$post['post_id'] = (int) $wp->post_id;
				$post['post_date'] = (string) $wp->post_date;
				$post['post_date_gmt'] = (string) $wp->post_date_gmt;
				$post['comment_status'] = (string) $wp->comment_status;
				$post['ping_status'] = (string) $wp->ping_status;
				$post['post_name'] = (string) $wp->post_name;
				$post['status'] = (string) $wp->status;
				$post['post_parent'] = (int) $wp->post_parent;
				$post['menu_order'] = (int) $wp->menu_order;
				$post['post_type'] = (string) $wp->post_type;
				$post['post_password'] = (string) $wp->post_password;
				$post['is_sticky'] = (int) $wp->is_sticky;

				if ( isset( $wp->attachment_url ) ) {
					$post['attachment_url'] = (string) $wp->attachment_url;
				}

				foreach ( $item->category as $c ) {
						$att = $c->attributes();
					if ( isset( $att['nicename'] ) ) {
						$post['terms'][] = array(
						'name' => (string) $c,
						'slug' => (string) $att['nicename'],
						'domain' => (string) $att['domain'],
						);
					}
				}

				foreach ( $wp->postmeta as $meta ) {
						$post['postmeta'][] = array(
							'key' => (string) $meta->meta_key,
							'value' => (string) $meta->meta_value,
						);
				}

				foreach ( $wp->comment as $comment ) {
						$meta = array();
					if ( isset( $comment->commentmeta ) ) {
						foreach ( $comment->commentmeta as $m ) {
							$meta[] = array(
								'key' => (string) $m->meta_key,
								'value' => (string) $m->meta_value,
							);
						}
					}

						$post['comments'][] = array(
							'comment_id' => (int) $comment->comment_id,
							'comment_author' => (string) $comment->comment_author,
							'comment_author_email' => (string) $comment->comment_author_email,
							'comment_author_IP' => (string) $comment->comment_author_IP,
							'comment_author_url' => (string) $comment->comment_author_url,
							'comment_date' => (string) $comment->comment_date,
							'comment_date_gmt' => (string) $comment->comment_date_gmt,
							'comment_content' => (string) $comment->comment_content,
							'comment_approved' => (string) $comment->comment_approved,
							'comment_type' => (string) $comment->comment_type,
							'comment_parent' => (string) $comment->comment_parent,
							'comment_user_id' => (int) $comment->comment_user_id,
							'commentmeta' => $meta,
						);
				}

				$posts[] = $post;
			}// End foreach().

			return array(
			'authors' => $authors,
			'posts' => $posts,
			'categories' => $categories,
			'tags' => $tags,
			'terms' => $terms,
			'base_url' => $base_url,
			'version' => $wxr_version,
			);
		}
	}}// End if().

/**
 * WXR Parser that makes use of the XML Parser PHP extension.
 */
if ( ! class_exists( 'PS_WXR_Parser_XML' ) ) {
	class PS_WXR_Parser_XML {
		var $wp_tags = array(
		'wp:post_id',
		'wp:post_date',
		'wp:post_date_gmt',
		'wp:comment_status',
		'wp:ping_status',
		'wp:attachment_url',
		'wp:status',
		'wp:post_name',
		'wp:post_parent',
		'wp:menu_order',
		'wp:post_type',
		'wp:post_password',
		'wp:is_sticky',
		'wp:term_id',
		'wp:category_nicename',
		'wp:category_parent',
		'wp:cat_name',
		'wp:category_description',
		'wp:tag_slug',
		'wp:tag_name',
		'wp:tag_description',
		'wp:term_taxonomy',
		'wp:term_parent',
		'wp:term_name',
		'wp:term_description',
		'wp:author_id',
		'wp:author_login',
		'wp:author_email',
		'wp:author_display_name',
		'wp:author_first_name',
		'wp:author_last_name',
			);
			var $wp_sub_tags = array(
			'wp:comment_id',
		'wp:comment_author',
		'wp:comment_author_email',
		'wp:comment_author_url',
			'wp:comment_author_IP',
		'wp:comment_date',
		'wp:comment_date_gmt',
		'wp:comment_content',
			'wp:comment_approved',
		'wp:comment_type',
		'wp:comment_parent',
		'wp:comment_user_id',
			);

		function parse( $file ) {
			$this->wxr_version = $this->in_post = $this->cdata = $this->data = $this->sub_data = $this->in_tag = $this->in_sub_tag = false;
			$this->authors = $this->posts = $this->term = $this->category = $this->tag = array();

			$xml = xml_parser_create( 'UTF-8' );
			xml_parser_set_option( $xml, XML_OPTION_SKIP_WHITE, 1 );
			xml_parser_set_option( $xml, XML_OPTION_CASE_FOLDING, 0 );
			xml_set_object( $xml, $this );
			xml_set_character_data_handler( $xml, 'cdata' );
			xml_set_element_handler( $xml, 'tag_open', 'tag_close' );

			if ( ! xml_parse( $xml, file_get_contents( $file ), true ) ) {
				$current_line = xml_get_current_line_number( $xml );
				$current_column = xml_get_current_column_number( $xml );
				$error_code = xml_get_error_code( $xml );
				$error_string = xml_error_string( $error_code );
				return new WP_Error( 'XML_parse_error', 'There was an error when reading this WXR file', array( $current_line, $current_column, $error_string ) );
			}
			xml_parser_free( $xml );

			if ( ! preg_match( '/^\d+\.\d+$/', $this->wxr_version ) ) {
				return new WP_Error( 'WXR_parse_error', __( 'This does not appear to be a WXR file, missing/invalid WXR version number', 'wordpress-importer' ) );
			}

			return array(
				'authors' => $this->authors,
				'posts' => $this->posts,
				'categories' => $this->category,
				'tags' => $this->tag,
				'terms' => $this->term,
				'base_url' => $this->base_url,
				'version' => $this->wxr_version,
				);
		}

		function tag_open( $parse, $tag, $attr ) {
			if ( in_array( $tag, $this->wp_tags ) ) {
				$this->in_tag = substr( $tag, 3 );
				return;
			}

			if ( in_array( $tag, $this->wp_sub_tags ) ) {
				$this->in_sub_tag = substr( $tag, 3 );
				return;
			}

			switch ( $tag ) {
				case 'category':
					if ( isset( $attr['domain'], $attr['nicename'] ) ) {
						$this->sub_data['domain'] = $attr['domain'];
						$this->sub_data['slug'] = $attr['nicename'];
					}
					break;
				case 'item': $this->in_post = true;
				case 'title': if ( $this->in_post ) { $this->in_tag = 'post_title';
				} break;
				case 'guid': $this->in_tag = 'guid';
break;
				case 'dc:creator': $this->in_tag = 'post_author';
break;
				case 'content:encoded': $this->in_tag = 'post_content';
break;
				case 'excerpt:encoded': $this->in_tag = 'post_excerpt';
break;

				case 'wp:term_slug': $this->in_tag = 'slug';
break;
				case 'wp:meta_key': $this->in_sub_tag = 'key';
break;
				case 'wp:meta_value': $this->in_sub_tag = 'value';
break;
			}
		}

		function cdata( $parser, $cdata ) {
			if ( ! trim( $cdata ) ) {
				return;
			}

			$this->cdata .= trim( $cdata );
		}

		function tag_close( $parser, $tag ) {
			switch ( $tag ) {
				case 'wp:comment':
					unset( $this->sub_data['key'], $this->sub_data['value'] ); // remove meta sub_data
					if ( ! empty( $this->sub_data ) ) {
						$this->data['comments'][] = $this->sub_data;
					}
					$this->sub_data = false;
					break;
				case 'wp:commentmeta':
					$this->sub_data['commentmeta'][] = array(
						'key' => $this->sub_data['key'],
						'value' => $this->sub_data['value'],
					);
					break;
				case 'category':
					if ( ! empty( $this->sub_data ) ) {
						$this->sub_data['name'] = $this->cdata;
						$this->data['terms'][] = $this->sub_data;
					}
					$this->sub_data = false;
					break;
				case 'wp:postmeta':
					if ( ! empty( $this->sub_data ) ) {
						$this->data['postmeta'][] = $this->sub_data;
					}
					$this->sub_data = false;
					break;
				case 'item':
					$this->posts[] = $this->data;
					$this->data = false;
					break;
				case 'wp:category':
				case 'wp:tag':
				case 'wp:term':
					$n = substr( $tag, 3 );
					array_push( $this->$n, $this->data );
					$this->data = false;
					break;
				case 'wp:author':
					if ( ! empty( $this->data['author_login'] ) ) {
						$this->authors[ $this->data['author_login'] ] = $this->data;
					}
					$this->data = false;
					break;
				case 'wp:base_site_url':
					$this->base_url = $this->cdata;
					break;
				case 'wp:wxr_version':
					$this->wxr_version = $this->cdata;
					break;

				default:
					if ( $this->in_sub_tag ) {
						$this->sub_data[ $this->in_sub_tag ] = ! empty( $this->cdata ) ? $this->cdata : '';
						$this->in_sub_tag = false;
					} elseif ( $this->in_tag ) {
						$this->data[ $this->in_tag ] = ! empty( $this->cdata ) ? $this->cdata : '';
						$this->in_tag = false;
					}
			}// End switch().

			$this->cdata = false;
		}
	}}// End if().

/**
 * WXR Parser that uses regular expressions. Fallback for installs without an XML parser.
 */
if ( ! class_exists( 'PS_WXR_Parser_Regex' ) ) {
	class PS_WXR_Parser_Regex {
		var $authors = array();
		var $posts = array();
		var $categories = array();
		var $tags = array();
		var $terms = array();
		var $base_url = '';

		function WXR_Parser_Regex() {
			$this->__construct();
		}

		function __construct() {
			$this->has_gzip = is_callable( 'gzopen' );
		}

		function parse( $file ) {
			$wxr_version = $in_post = false;

			$fp = $this->fopen( $file, 'r' );
			if ( $fp ) {
				while ( ! $this->feof( $fp ) ) {
					$importline = rtrim( $this->fgets( $fp ) );

					if ( ! $wxr_version && preg_match( '|<wp:wxr_version>(\d+\.\d+)</wp:wxr_version>|', $importline, $version ) ) {
						$wxr_version = $version[1];
					}

					if ( false !== strpos( $importline, '<wp:base_site_url>' ) ) {
						preg_match( '|<wp:base_site_url>(.*?)</wp:base_site_url>|is', $importline, $url );
						$this->base_url = $url[1];
						continue;
					}
					if ( false !== strpos( $importline, '<wp:category>' ) ) {
						preg_match( '|<wp:category>(.*?)</wp:category>|is', $importline, $category );
						$this->categories[] = $this->process_category( $category[1] );
						continue;
					}
					if ( false !== strpos( $importline, '<wp:tag>' ) ) {
						preg_match( '|<wp:tag>(.*?)</wp:tag>|is', $importline, $tag );
						$this->tags[] = $this->process_tag( $tag[1] );
						continue;
					}
					if ( false !== strpos( $importline, '<wp:term>' ) ) {
						preg_match( '|<wp:term>(.*?)</wp:term>|is', $importline, $term );
						$this->terms[] = $this->process_term( $term[1] );
						continue;
					}
					if ( false !== strpos( $importline, '<wp:author>' ) ) {
						preg_match( '|<wp:author>(.*?)</wp:author>|is', $importline, $author );
						$a = $this->process_author( $author[1] );
						$this->authors[ $a['author_login'] ] = $a;
						continue;
					}
					if ( false !== strpos( $importline, '<item>' ) ) {
						$post = '';
						$in_post = true;
						continue;
					}
					if ( false !== strpos( $importline, '</item>' ) ) {
						$in_post = false;
						$this->posts[] = $this->process_post( $post );
						continue;
					}
					if ( $in_post ) {
						$post .= $importline . "\n";
					}
				}// End while().

				$this->fclose( $fp );
			}// End if().

			if ( ! $wxr_version ) {
				return new WP_Error( 'WXR_parse_error', __( 'This does not appear to be a WXR file, missing/invalid WXR version number', 'wordpress-importer' ) );
			}

			return array(
			'authors' => $this->authors,
			'posts' => $this->posts,
			'categories' => $this->categories,
			'tags' => $this->tags,
			'terms' => $this->terms,
			'base_url' => $this->base_url,
			'version' => $wxr_version,
			);
		}

		function get_tag( $string, $tag ) {
			preg_match( "|<$tag.*?>(.*?)</$tag>|is", $string, $return );
			if ( isset( $return[1] ) ) {
				if ( substr( $return[1], 0, 9 ) == '<![CDATA[' ) {
					if ( strpos( $return[1], ']]]]><![CDATA[>' ) !== false ) {
						preg_match_all( '|<!\[CDATA\[(.*?)\]\]>|s', $return[1], $matches );
						$return = '';
						foreach ( $matches[1] as $match ) {
							$return .= $match;
						}
					} else {
						$return = preg_replace( '|^<!\[CDATA\[(.*)\]\]>$|s', '$1', $return[1] );
					}
				} else {
					$return = $return[1];
				}
			} else {
				$return = '';
			}
			return $return;
		}

		function process_category( $c ) {
			return array(
			'term_id' => $this->get_tag( $c, 'wp:term_id' ),
			'cat_name' => $this->get_tag( $c, 'wp:cat_name' ),
			'category_nicename'	=> $this->get_tag( $c, 'wp:category_nicename' ),
			'category_parent' => $this->get_tag( $c, 'wp:category_parent' ),
			'category_description' => $this->get_tag( $c, 'wp:category_description' ),
			);
		}

		function process_tag( $t ) {
			return array(
			'term_id' => $this->get_tag( $t, 'wp:term_id' ),
			'tag_name' => $this->get_tag( $t, 'wp:tag_name' ),
			'tag_slug' => $this->get_tag( $t, 'wp:tag_slug' ),
			'tag_description' => $this->get_tag( $t, 'wp:tag_description' ),
			);
		}

		function process_term( $t ) {
			return array(
			'term_id' => $this->get_tag( $t, 'wp:term_id' ),
			'term_taxonomy' => $this->get_tag( $t, 'wp:term_taxonomy' ),
			'slug' => $this->get_tag( $t, 'wp:term_slug' ),
			'term_parent' => $this->get_tag( $t, 'wp:term_parent' ),
			'term_name' => $this->get_tag( $t, 'wp:term_name' ),
			'term_description' => $this->get_tag( $t, 'wp:term_description' ),
			);
		}

		function process_author( $a ) {
			return array(
			'author_id' => $this->get_tag( $a, 'wp:author_id' ),
			'author_login' => $this->get_tag( $a, 'wp:author_login' ),
			'author_email' => $this->get_tag( $a, 'wp:author_email' ),
			'author_display_name' => $this->get_tag( $a, 'wp:author_display_name' ),
			'author_first_name' => $this->get_tag( $a, 'wp:author_first_name' ),
			'author_last_name' => $this->get_tag( $a, 'wp:author_last_name' ),
			);
		}

		function process_post( $post ) {
			$post_id        = $this->get_tag( $post, 'wp:post_id' );
			$post_title     = $this->get_tag( $post, 'title' );
			$post_date      = $this->get_tag( $post, 'wp:post_date' );
			$post_date_gmt  = $this->get_tag( $post, 'wp:post_date_gmt' );
			$comment_status = $this->get_tag( $post, 'wp:comment_status' );
			$ping_status    = $this->get_tag( $post, 'wp:ping_status' );
			$status         = $this->get_tag( $post, 'wp:status' );
			$post_name      = $this->get_tag( $post, 'wp:post_name' );
			$post_parent    = $this->get_tag( $post, 'wp:post_parent' );
			$menu_order     = $this->get_tag( $post, 'wp:menu_order' );
			$post_type      = $this->get_tag( $post, 'wp:post_type' );
			$post_password  = $this->get_tag( $post, 'wp:post_password' );
			$is_sticky      = $this->get_tag( $post, 'wp:is_sticky' );
			$guid           = $this->get_tag( $post, 'guid' );
			$post_author    = $this->get_tag( $post, 'dc:creator' );

			$post_excerpt = $this->get_tag( $post, 'excerpt:encoded' );
			$post_excerpt = preg_replace_callback( '|<(/?[A-Z]+)|', array( &$this, '_normalize_tag' ), $post_excerpt );
			$post_excerpt = str_replace( '<br>', '<br />', $post_excerpt );
			$post_excerpt = str_replace( '<hr>', '<hr />', $post_excerpt );

			$post_content = $this->get_tag( $post, 'content:encoded' );
			$post_content = preg_replace_callback( '|<(/?[A-Z]+)|', array( &$this, '_normalize_tag' ), $post_content );
			$post_content = str_replace( '<br>', '<br />', $post_content );
			$post_content = str_replace( '<hr>', '<hr />', $post_content );

			$postdata = compact( 'post_id', 'post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_excerpt',
				'post_title', 'status', 'post_name', 'comment_status', 'ping_status', 'guid', 'post_parent',
				'menu_order', 'post_type', 'post_password', 'is_sticky'
			);

			$attachment_url = $this->get_tag( $post, 'wp:attachment_url' );
			if ( $attachment_url ) {
				$postdata['attachment_url'] = $attachment_url;
			}

			preg_match_all( '|<category domain="([^"]+?)" nicename="([^"]+?)">(.+?)</category>|is', $post, $terms, PREG_SET_ORDER );
			foreach ( $terms as $t ) {
					$post_terms[] = array(
						'slug' => $t[2],
						'domain' => $t[1],
						'name' => str_replace( array( '<![CDATA[', ']]>' ), '', $t[3] ),
					);
			}
			if ( ! empty( $post_terms ) ) { $postdata['terms'] = $post_terms;
			}

			preg_match_all( '|<wp:comment>(.+?)</wp:comment>|is', $post, $comments );
			$comments = $comments[1];
			if ( $comments ) {
				foreach ( $comments as $comment ) {
					preg_match_all( '|<wp:commentmeta>(.+?)</wp:commentmeta>|is', $comment, $commentmeta );
					$commentmeta = $commentmeta[1];
					$c_meta = array();
					foreach ( $commentmeta as $m ) {
						$c_meta[] = array(
							'key' => $this->get_tag( $m, 'wp:meta_key' ),
							'value' => $this->get_tag( $m, 'wp:meta_value' ),
						);
					}

					$post_comments[] = array(
						'comment_id' => $this->get_tag( $comment, 'wp:comment_id' ),
						'comment_author' => $this->get_tag( $comment, 'wp:comment_author' ),
						'comment_author_email' => $this->get_tag( $comment, 'wp:comment_author_email' ),
						'comment_author_IP' => $this->get_tag( $comment, 'wp:comment_author_IP' ),
						'comment_author_url' => $this->get_tag( $comment, 'wp:comment_author_url' ),
						'comment_date' => $this->get_tag( $comment, 'wp:comment_date' ),
						'comment_date_gmt' => $this->get_tag( $comment, 'wp:comment_date_gmt' ),
						'comment_content' => $this->get_tag( $comment, 'wp:comment_content' ),
						'comment_approved' => $this->get_tag( $comment, 'wp:comment_approved' ),
						'comment_type' => $this->get_tag( $comment, 'wp:comment_type' ),
						'comment_parent' => $this->get_tag( $comment, 'wp:comment_parent' ),
						'comment_user_id' => $this->get_tag( $comment, 'wp:comment_user_id' ),
						'commentmeta' => $c_meta,
					);
				}
			}
			if ( ! empty( $post_comments ) ) { $postdata['comments'] = $post_comments;
			}

			preg_match_all( '|<wp:postmeta>(.+?)</wp:postmeta>|is', $post, $postmeta );
			$postmeta = $postmeta[1];
			if ( $postmeta ) {
				foreach ( $postmeta as $p ) {
					$post_postmeta[] = array(
						'key' => $this->get_tag( $p, 'wp:meta_key' ),
						'value' => $this->get_tag( $p, 'wp:meta_value' ),
					);
				}
			}
			if ( ! empty( $post_postmeta ) ) { $postdata['postmeta'] = $post_postmeta;
			}

			return $postdata;
		}

		function _normalize_tag( $matches ) {
			return '<' . strtolower( $matches[1] );
		}

		function fopen( $filename, $mode = 'r' ) {
			if ( $this->has_gzip ) {
				return gzopen( $filename, $mode );
			}
			return fopen( $filename, $mode );
		}

		function feof( $fp ) {
			if ( $this->has_gzip ) {
				return gzeof( $fp );
			}
			return feof( $fp );
		}

		function fgets( $fp, $len = 8192 ) {
			if ( $this->has_gzip ) {
				return gzgets( $fp, $len );
			}
			return fgets( $fp, $len );
		}

		function fclose( $fp ) {
			if ( $this->has_gzip ) {
				return gzclose( $fp );
			}
			return fclose( $fp );
		}
	}}// End if().
