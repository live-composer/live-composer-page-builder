<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>
<div class="wrap lc-wrap about-wrap dslc-tab-extend">

<div class="feature-section one-col">
	<div class="col">
		<h2><?php _e( 'An Update with You in Mind' ); ?></h2>
		<p class="lead-description"><?php _e( 'WordPress 4.8 adds some great new features. Gear up for a more intuitive WordPress!' ); ?></p>
		<p><?php _e( 'Though some updates seem minor, they&#8217;ve been built by hundreds of contributors with <em>you</em> in mind. Get ready for new features you&#8217;ll welcome like an old friend: link improvements, <em>three</em> new media widgets covering images, audio, and video, an updated text widget that supports visual editing, and an upgraded news section in your dashboard which brings in nearby and upcoming WordPress events.' ); ?></p>
	</div>
</div>

<hr />

<h2><?php _e( 'Exciting Widget Updates' ); ?></h2>

<div class="headline-feature one-col">
	<div class="col">
		<picture>
			<!-- Large image -->
			<source media="( min-width: 1050px )"
				srcset="
					https://s.w.org/images/core/4.8/widgets-with-all-four-widescreen_w_810.png 810w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-widescreen_w_1054.png 1054w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-widescreen_w_1266.png 1266w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-widescreen_w_1458.png 1458w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-widescreen_w_1633.png 1633w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-widescreen_w_1797.png 1797w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-widescreen_w_1955.png 1955w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-widescreen_w_2100.png 2100w"
				sizes="( max-width: 1290px ) calc( 100vw - 240px ), 1050px" />
			<!-- Medium image -->
			<source media="( min-width: 601px )"
				srcset="
					https://s.w.org/images/core/4.8/widgets-with-all-four_w_531.png 531w,
					https://s.w.org/images/core/4.8/widgets-with-all-four_w_745.png 745w,
					https://s.w.org/images/core/4.8/widgets-with-all-four_w_927.png 927w,
					https://s.w.org/images/core/4.8/widgets-with-all-four_w_1089.png 1089w,
					https://s.w.org/images/core/4.8/widgets-with-all-four_w_1236.png 1236w,
					https://s.w.org/images/core/4.8/widgets-with-all-four_w_1370.png 1370w,
					https://s.w.org/images/core/4.8/widgets-with-all-four_w_1498.png 1498w,
					https://s.w.org/images/core/4.8/widgets-with-all-four_w_1620.png 1620w"
				sizes="( max-width: 782px ) calc( 100vw - 70px ), ( max-width: 960px ) calc( 100vw - 116px ), calc( 100vw - 240px )" />
			<!-- Small image -->
			<img src="https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_685.png"
				srcset="
					https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_300.png 300w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_451.png 451w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_575.png 575w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_685.png 685w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_784.png 784w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_873.png 873w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_959.png 959w,
					https://s.w.org/images/core/4.8/widgets-with-all-four-mobile_w_1040.png 1040w"
				sizes="( max-width: 500px ) calc( 100vw - 40px ), calc( 100vw - 70px )"
				alt="" />
		</picture>
	</div>
</div>

<div class="feature-section two-col">
	<div class="col">
		<h3><?php _e( 'Image Widget' ); ?></h3>
		<p><?php _e( 'Adding an image to a widget is now a simple task that is achievable for any WordPress user without needing to know code. Simply insert your image right within the widget settings. Try adding something like a headshot or a photo of your latest weekend adventure &mdash; and see it appear automatically.' ); ?></p>
	</div>
	<div class="col">
		<h3><?php _e( 'Video Widget' ); ?></h3>
		<p><?php _e( 'A welcome video is a great way to humanize the branding of your website. You can now add any video from the Media Library to a sidebar on your site with the new Video widget. Use this to showcase a welcome video to introduce visitors to your site or promote your latest and greatest content.' ); ?></p>
	</div>
	<div class="col">
		<h3><?php _e( 'Audio Widget' ); ?></h3>
		<p><?php _e( 'Are you a podcaster, musician, or avid blogger? Adding a widget with your audio file has never been easier. Upload your audio file to the Media Library, go to the widget settings, select your file, and you&#8217;re ready for listeners. This would be a easy way to add a more personal welcome message, too!' );?></p>
	</div>
	<div class="col">
		<h3><?php _e( 'Rich Text Widget' ); ?></h3>
		<p><?php _e( 'This feature deserves a parade down the center of town! Rich-text editing capabilities are now native for Text widgets. Add a widget anywhere and format away. Create lists, add emphasis, and quickly and easily insert links. Have fun with your newfound formatting powers, and watch what you can accomplish in a short amount of time.' ); ?></p>
	</div>
</div>

<hr />

<div class="feature-section two-col">
	<div class="col">
		<h3><?php _e( 'Link Boundaries' ); ?></h3>
		<p><?php _e( 'Have you ever tried updating a link, or the text around a link, and found you can&#8217;t seem to edit it correctly? When you edit the text after the link, your new text also ends up linked. Or you edit the text in the link, but your text ends up outside of it. This can be frustrating! With link boundaries, a great new feature, the process is streamlined and your links will work well. You’ll be happier. We promise.' ); ?></p>
	</div>
	<div class="col">
		<?php
		echo wp_video_shortcode( array(
			'mp4'      => 'https://s.w.org/images/core/4.8/link-boundaries.mp4',
			'poster'   => 'https://s.w.org/images/core/4.8/link-boundaries.png',
			'width'    => 1140,
			'height'   => 624,
			// 'class'    => 'wp-video-shortcode feature-video',
		) );
		?>
	</div>
</div>

<hr />

<div class="feature-section two-col">
	<div class="col">
		<h3><?php _e( 'Nearby WordPress Events' ); ?></h3>

		<p><?php _e( 'Did you know that WordPress has a thriving offline community with groups meeting regularly in more than 400 cities around the world? WordPress now draws your attention to the events that help you continue improving your WordPress skills, meet friends, and, of course, publish!' ); ?></p>

		<p><?php _e( 'This is quickly becoming one of our favorite features. While you are in the dashboard (because you&#8217;re running updates and writing posts, right?) all upcoming WordCamps and WordPress Meetups &mdash; local to you &mdash; will be displayed.' ); ?>

		<p><?php _e( 'Being part of the community can help you improve your WordPress skills and network with people you wouldn&#8217;t otherwise meet. Now you can easily find your local events just by logging in to your dashboard and looking at the new Events and News dashboard widget.' ); ?>
	</div>
	<div class="col">
		<img
			src="https://s.w.org/images/core/4.8/events-widget_w_732.png"
			srcset="
				https://s.w.org/images/core/4.8/events-widget_w_280.png 280w,
				https://s.w.org/images/core/4.8/events-widget_w_420.png 420w,
				https://s.w.org/images/core/4.8/events-widget_w_529.png 529w,
				https://s.w.org/images/core/4.8/events-widget_w_638.png 638w,
				https://s.w.org/images/core/4.8/events-widget_w_732.png 732w,
				https://s.w.org/images/core/4.8/events-widget_w_827.png 827w,
				https://s.w.org/images/core/4.8/events-widget_w_992.png 992w"
			sizes="
				( max-width: 500px ) calc( 100vw - 40px ),
				( max-width: 782px ) calc( 48vw - 33px ),
				( max-width: 960px ) calc( 47vw - 54px ),
				( max-width: 1290px ) calc( 47vw - 112px ),
				496px"
			alt="" />
	</div>
</div>

</div>