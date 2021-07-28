<?php
	require('blog/wp-blog-header.php');
	require_once( ABSPATH . WPINC . '/rss.php' );
	include_once( 'life.php' );
	ini_set( "display_errors", 0);
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="Copyright" content="Copyright &copy; Gregor Smith 1999 - <?php echo date('Y'); ?>. All rights reserved" />
		<title>Life Stream</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="main.css" type="text/css" />
	</head>

	<body>
		<div class="container-lg">
			<div class="row">
				<div class="header col-12">
					<h1 class="mt-4">Life Stream</h1>
					<small>Something witty and entertaining?</small>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 col-lg-4 order-sm-1 order-lg-2">
					<h3 class="mt-4">Sidebar, but also a subhead</h3>
					<p>A short introduction maybe? Not needed, it just breaks up the screen full of colourful lines.</p>

					<h3>My Feeds</h3>
					<div class="table-responsive">
						<table class="table table-borderless">
							<tbody>
								<tr class="life_twitter">
									<td class="life_logo p-2"><img src="images/life_twitter.png" alt="Twitter" /></td>
									<td class="life_post"><a href="#" title="Twitter">Twitter Feed</a></td>
								</tr>
								<tr class="life_facebook">
									<td class="life_logo p-2"><img src="images/life_facebook.png" alt="Facebook" /></td>
									<td class="life_post"><a href="#" title="Facebook">Facebook Feed</a></td>
								</tr>
								<tr class="life_foursquare">
									<td class="life_logo p-2"><img src="images/life_foursquare.png" alt="Foursquare Locations" /></td>
									<td class="life_post"><a href="#" title="Foursquare Locations">Foursquare Locations Feed</a></td>
								</tr>
								<tr class="life_instagram">
									<td class="life_logo p-2"><img src="images/life_instagram.png" alt="Instagram" /></td>
									<td class="life_post"><a href="#" title="Instagram">Instagram Feed</a></td>
								</tr>
								<tr class="life_youtube">
									<td class="life_logo p-2"><img src="images/life_youtube.png" alt="YouTube Channel" /></td>
									<td class="life_post"><a href="#" title="YouTube Channel">YouTube Channel Feed</a></td>
								</tr>
								<tr class="life_flickr">
									<td class="life_logo p-2"><img src="images/life_flickr.png" alt="Flickr" /></td>
									<td class="life_post"><a href="#" title="Flickr">Flickr Feed</a></td>
								</tr>
								<tr class="life_lastfm">
									<td class="life_logo p-2"><img src="images/life_lastfm.png" alt="Last FM" /></td>
									<td class="life_post"><a href="#" title="Last FM">Last FM Feed</a></td>
								</tr>
							</tbody>
						</table>
					</div>
					<h3>My Feed of Feeds</h3>
					<div class="table-responsive">
						<table class="table table-borderless">
							<tbody>
								<tr class="life_lifestream">
									<td class="life_logo p-2 m-1"><img src="images/life_lifestream.png" alt="Lifestream" /></td>
									<td class="life_post"><a href="#" title="Lifestream">Lifestream Feed</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-sm-12 col-lg-8 order-sm-2 order-lg-1">
					<div class="table-responsive">
						<table class="table table-borderless">
							<?php
								date_default_timezone_set("America/New_York");
								define('MAGPIE_CACHE_AGE', 10*10); // ten minutes, I think.
								$details = array('title','link');
								$list = array();
								
								foreach ( life::defaultStreams() as $name => $feed ) {
									$rss = @fetch_rss( $feed );
									$items = $rss->items = array_slice( $rss->items, 0 );
									
									foreach ($items as $item ) {
										$date = strtotime( substr( $item['pubdate'], 0, 25 ) );
									if( $name == "life_twitter") {
										$date += 3600*5;
									}
									if( $name == "life_facebook") {
										$date += 3600*5;
									}
									if( $name == "life_foursquare") {
										$date += 3600*5;
									}
									if( $name == "life_instagram") {
										$date += 3600*5;
									}
									if( $name == "life_youtube") {
										$date += 3600*0;
									}
									else {
										$date -= 3600*5;
									}
									$list[ $date ][ "name" ] = $name;
									
									foreach ($details as $detail) {
										$list[$date]['title'] = $item['title'];
										
										$list[$date]['link'] = $item['link'];
										}
									}
								}
								krsort( $list );
								$day = '';
								foreach ( $list as $timestamp => $item ) {
									$this_day = date("F jS Y",$timestamp );
								if ( $day != $this_day ) {
							?>
							<thead>
								<tr>
									<th colspan="3" class="life_date">
										<h3 class="mt-4"><?php echo $this_day; ?></h3>
									</th>
								</tr>
							</thead>
							<tbody>
							<?php $day = $this_day; } ?>
							<tr class="<?php  echo $item["name"]; ?>" />
								<td class="life_logo p-2"><img src="<?php echo 'images/' . $item["name"] . '.png'; ?>" alt="<?php echo $item["name"]; ?>" /></td>
								<th class="life_time p-2"><?php echo date("g:ia",$timestamp); ?></th>
								<td class="life_post"><a class="url summary" href="<?php echo $item["link"]; ?>" title="<?php echo $item["title"]; ?>"><?php echo $item["title"]; ?></a></td>
							</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="footer text-center span-12 mt-4 mb-4">
					<p>Copyright &copy; Someone <?php echo date('Y'); ?>. All rights reserved</p>
				</div>
			</div>

		</div>

	</body>
</html>