<?php
require('path/to/wp-blog-header.php');
require_once( ABSPATH . WPINC . '/rss-functions.php' );
include_once( 'life.php' );
ini_set( "display_errors", 0);
?>

      <table border="0" cellpadding="0" cellspacing="0" class="hcalendar">
        <tbody>
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
				if( $name == "life_flickr") {
				$date += 3600*13;
				}
				if( $name == "life_twitter") {
				$date += 3600*6;
				}
				if( $name == "life_lastfm") {
				$date += 3600*6;
				}
				if( $name == "life_foursquare") {
				$date += 3600*13;
				}
				if( $name == "life_facebook") {
				$date += 3600*6;
				}
				if( $name == "life_blog") {
				$date += 3600*1;
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
    $this_day = date("F jS",$timestamp );
    	if ( $day != $this_day ) {
?>
        </tbody>
        <thead>
          <tr>
            <th colspan="3" align="left"> <br/>
              <h2><?php echo $this_day; ?></h2></th>
          </tr>
        </thead>
        </tbody>
        
        <?php $day = $this_day; } ?>
        <tr class="<?php  echo $item["name"]; ?>" />
        <td><img src="<?php echo 'images/' . $item["name"] . '.gif'; ?>" alt="<?php echo $item["name"]; ?>" /></td>
          <th><?php echo date("g:ia",$timestamp); ?></th>
          <td><a class="url summary" href="<?php echo $item["link"]; ?>" title="<?php echo $item["title"]; ?>"><?php echo $item["title"]; ?></a> </td>
        </tr>
        <?php } ?>
        </tbody>
      </table>