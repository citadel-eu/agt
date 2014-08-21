<?php
include_once 'Config.php';
include_once CLASSES . 'App.class.php';
include_once CLASSES . 'Database.class.php';
include_once CLASSES . 'defineColor.php';
include_once CLASSES . 'cities.php';

$currentAppName = "Loading app...";
$appID = isset($_GET['uid']) ? $_GET['uid'] : '';
$colors = printColors($appID);
?>

<!DOCTYPE html>
<html>
    <head> 
        <title>App Generation Tool</title> 
        <!--------------- Metatags ------------------->   
        <meta charset="utf-8" />
        <!-- Not allowing the user to zoom -->    
        <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0, minimum-scale=1.0"/>
        <!-- iphone-related meta tags to allow the page to be bookmarked -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta name="description" content="Mobile Application app generated by the Citadel AGT.">  
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <!--------------- Facebook metatags------------>
        <meta property="og:title" content="Citadel... on the move"/>
        <meta property="og:site_name" content="Citadel Application generation Tool"/>
        <meta property="og:image" content="<?php echo SERVERNAME . BASE_DIR ?>images/logoCitadel.png"/>

        <!--------------- CSS files ------------------->  
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jquerymobile/1.4.2/jquery.mobile.min.css" />
        <!--          <link rel="stylesheet" href="css/app-generator.min.css">-->
        <link rel="stylesheet" href="css/my.css" />    

        <!--------------- Add a sortcut to home screen------------>
        <link rel="apple-touch-icon" href="images/logoCitadel.png"/>
        <link rel="apple-touch-startup-image" href="images/logoCitadel.png">
        <meta name="apple-mobile-web-app-capable" content="yes" />

        <style>

            .ui-page-theme-a .ui-btn.ui-btn-active, html .ui-bar-a .ui-btn.ui-btn-active, html .ui-body-a .ui-btn.ui-btn-active, html body .ui-group-theme-a .ui-btn.ui-btn-active, html head + body .ui-btn.ui-btn-a.ui-btn-active, .ui-page-theme-a .ui-checkbox-on:after, html .ui-bar-a .ui-checkbox-on:after, html .ui-body-a .ui-checkbox-on:after, html body .ui-group-theme-a .ui-checkbox-on:after, .ui-btn.ui-checkbox-on.ui-btn-a:after, .ui-page-theme-a .ui-flipswitch-active, html .ui-bar-a .ui-flipswitch-active, html .ui-body-a .ui-flipswitch-active, html body .ui-group-theme-a .ui-flipswitch-active, html body .ui-flipswitch.ui-bar-a.ui-flipswitch-active, .ui-page-theme-a .ui-slider-track .ui-btn-active, html .ui-bar-a .ui-slider-track .ui-btn-active, html .ui-body-a .ui-slider-track .ui-btn-active, html body .ui-group-theme-a .ui-slider-track .ui-btn-active, html body div.ui-slider-track.ui-body-a .ui-btn-active {
                background-color: <?php echo $colors['darkColor'] ?> !important;
                border-color: <?php echo $colors['darkColor'] ?>;
                color:#fff;
                text-shadow: 0 1px 0 #000;
            }

            .ui-page-theme-a .ui-btn, html .ui-bar-a .ui-btn, html .ui-body-a .ui-btn, html body .ui-group-theme-a .ui-btn, html head + body .ui-btn.ui-btn-a, .ui-page-theme-a .ui-btn:visited, html .ui-bar-a .ui-btn:visited, html .ui-body-a .ui-btn:visited, html body .ui-group-theme-a .ui-btn:visited, html head + body .ui-btn.ui-btn-a:visited {
                background-color: <?php echo $colors['color'] ?>;
                color:#fff;
                text-shadow: 0 1px 0 #000;
            }

            .ui-page-theme-a .ui-radio-on:after, html .ui-bar-a .ui-radio-on:after, html .ui-body-a .ui-radio-on:after, html body .ui-group-theme-a .ui-radio-on:after, .ui-btn.ui-radio-on.ui-btn-a:after {
                border-color: <?php echo $colors['darkColor'] ?> ;
            }
            .ui-page-theme-a .ui-btn:focus, html .ui-bar-a .ui-btn:focus, html .ui-body-a .ui-btn:focus, html body .ui-group-theme-a .ui-btn:focus, html head + body .ui-btn.ui-btn-a:focus, .ui-page-theme-a .ui-focus, html .ui-bar-a .ui-focus, html .ui-body-a .ui-focus, html body .ui-group-theme-a .ui-focus, html head + body .ui-btn-a.ui-focus, html head + body .ui-body-a.ui-focus {
                box-shadow: 0 0 12px  <?php echo $colors['darkColor'] ?>;
            }
            .ui-page-theme-a .ui-btn:hover, html .ui-bar-a .ui-btn:hover, html .ui-body-a .ui-btn:hover, html body .ui-group-theme-a .ui-btn:hover, html head + body .ui-btn.ui-btn-a:hover {
                background-color:  <?php echo $colors['darkColor'] ?> !important;
                border-color:  <?php echo $colors['darkColor'] ?> ;
                color: #fff;
                text-shadow: 0 1px 0 #000;
            }

            #mapFilterList .ui-btn, #poiBubble .ui-btn ,  #mapFilterList .ui-btn, #poiBubble .ui-btn:hover,
            #cityFilterList .ui-btn, #poiBubble .ui-btn ,  #cityFilterList .ui-btn, #poiBubble .ui-btn:hover,
            #list .ui-btn, #poiBubble .ui-btn ,  #list .ui-btn, #poiBubble .ui-btn:hover
            {
                background-color: #f6f6f6 !important;
                color:#333!important;
                text-shadow:none!important;
                border-color: #ddd !important;
            }

        </style>

        <!--------------- Javascript dependencies -------------------> 
        <!-- Google Maps JavaScript API v3 -->    
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry">
        </script>
        <!-- Google Maps Utility Library - Infobubble -->     
        <script type="text/javascript"
                src = "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble.js">
        </script>


        <!-- Overlapping markers Library: Deals with overlapping markers in Google Maps -->
        <script src="js/oms.min.js"></script>  
        <!-- jQuery Library --> 
        <script src="js/jquery-1.8.2.min.js"></script>
        <!-- jQuery Mobile Library -->
        <script src="//ajax.googleapis.com/ajax/libs/jquerymobile/1.4.2/jquery.mobile.min.js"></script>

        <!-- Page params Library: Used to pass query params to embedded/internal pages of jQuery Mobile -->    
        <script src="js/jqm.page.params.js"></script>
        <!-- Template specific functions and handlers -->    
        <script src="js/app-generator-lib.js"></script>  
        <script src="js/jquery.ajax-progress.js"></script>  

        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "ur-cf1bb4ba-7f06-2a05-b666-52afb3356a9c", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>    


        <!-- /Progress Bar CSS file -->
        <link rel="stylesheet" type="text/css" href="css/jQMProgressBar.css" />
        <!-- /Progress Bar JS file -->
        <script type="text/javascript" src="js/jQMProgressBar.js"></script>

    </head> 

    <body>
        <!-- Home Page: Contains the Map -->
        <div data-role="page" id="page1" class="page">

            <div data-role="popup" id="popupMenu" data-theme="a">
                <ul data-role="listview" data-inset="true" style="min-width:210px;">
                    <li data-role="list-divider">How do you want to get there?</li>
                    <!--            <li><a href="#">View details</a></li>-->
                    <li><a  onclick="initStartingPoint('DRIVING')" ><img class="ui-li-icon" src='css/images/car-black.png' />Car</a></li>
                    <li><a  onclick="initStartingPoint('WALKING')" ><img  class="ui-li-icon"  src='css/images/walk2-black.png' />Walk</a></li>
                    <li><a  onclick="initStartingPoint('TRANSIT')"><img  class="ui-li-icon"  src='css/images/bus-black.png'  />Public transportation</a></li>
                </ul>
            </div>

            <!-- /Progress Bar for jQuery Mobile -->
            <div data-role="header" data-posistion="fixed" data-id="constantNav" data-fullscreen="true">
                <span class="ui-title"><?php echo $currentAppName ?></span>
                <a href="" id="filter" data-role="button" data-icon="filter" data-iconpos="notext"  data-theme="a" title="Categories" ></a>
                <a href="" id="city" data-role="button" data-icon="bars" data-iconpos="left" data-theme="a" title="Select City" >Cities</a>              

                <div data-role="navbar" class="navbar">
                    <ul>
                        <li><a href="#" class="pois-nearme ui-btn-active" data-theme="a">Map</a></li>
                        <li><a href="#page2" class="pois-list" data-theme="a">List</a></li>
                    </ul>
                </div><!-- /navbar -->
            </div>

            <div data-role="content" id="map-filter">
                <div class="filters-list" id="mapFilterList">
                    <fieldset data-role="controlgroup" data-mini="true" data-theme="a">
                        <!-- dynamically filled with data -->
                    </fieldset>
                </div>
                <footer data-role="footer" data-posistion="fixed" data-fullscreen="true" class="filter-footer">
                    <a href="" id="apply" data-icon="gear" data-theme="a" title="Apply" class="ui-btn-right">Apply</a>
                </footer>
            </div><!--map-filter-->

            <div data-role="content" id="city-filter">
                <div class="filters-list" id="cityFilterList">
                    <fieldset data-role="controlgroup" data-mini="true" data-theme="a">

                    </fieldset>
                </div>

            </div><!--city-filter-->

            <div data-role="content" id="map-container">
                <div id="progressbar"></div>
                <div id="map_canvas" class="map_canvas"></div>
            </div>

            <footer data-role="footer" data-posistion="fixed" data-fullscreen="true">
                <span class='st_facebook_large' displayText='Facebook'></span>
                <span class='st_twitter_large' displayText='Tweet'></span>
            </footer>

        </div>

        <!-- List Page: Contains a list with the results -->
        <div data-role="page" id="page2" class="page">

            <header data-role="header" data-posistion="fixed" data-id="constantNav">
                <span class="ui-title"><?php echo $currentAppName ?></span>
                <fieldset data-role="controlgroup" class="favourites-button">
                    <input type="checkbox" name="favourites" id="favourites" class="custom" />
                    <label for="favourites">Favourites</label>
                </fieldset>
                <a href="" data-icon="back" data-iconpos="notext" data-theme="a" title="Back" data-rel="back" class="ui-btn-right">&nbsp;</a>
                <div data-role="navbar" class="navbar">
                    <ul>
                        <li><a href="#" class="pois-nearme" data-theme="a">Map</a></li>
                        <li><a href="#page2" class="pois-list ui-btn-active" data-theme="a">List</a></li>
                    </ul>
                </div><!-- /navbar -->
            </header>

            <div class="list-container">
                <div class="list-scroll-container">
                    <div data-role="content" id="list">
                        <ul data-role='listview' data-inset='true' data-filter='true' data-theme='a'>
                            <!-- dynamically filled with data -->
                        </ul>
                    </div><!--list-->
                </div><!--list-scroll-container-->
            </div><!--list-container-->
        </div><!-- /page -->

        <!-- Details Page: Contains the details of a selected element -->
        <div data-role="page" id="page3" data-title="Event fullstory page title" class="page">
            <header data-role="header" data-posistion="fixed" data-fullscreen="true">
                <span class="ui-title"><?php echo $currentAppName ?></span>
                <a href="" data-icon="back" data-iconpos="notext" data-theme="a" title="Back" data-rel="back" class="ui-btn-right">&nbsp;</a>
                <div data-role="navbar" class="navbar">
                    <ul>
                        <li><a href="#" class="pois-nearme" data-theme="a">Map</a></li>
                        <li><a href="#page2" class="pois-list" data-theme="a">List</a></li>
                    </ul>
                </div><!-- /navbar --> 
            </header>

            <div class="list-container">
                <div class="list-scroll-container">
                    <div data-role="content" id="item">
                        <!-- dynamically filled with data -->
                    </div><!--item-->
                    <ul><li><div class='votePanel'>
                                <p>Rate this POI</p>
                                <span class="voteScoreWrapper">
                                    <img id='voteUpButton'  class='voting-icon'  src='images/like-32.png'  alt='Vote up' />
                                    <span id='upVoteScore'><img  src='images/loader.png'  /></span>
                                </span><span  class="voteScoreWrapper" id="voteDownScoreWrapper">
                                    <img  class='voting-icon'  id='voteDownButton'  src='images/dislike-32.png' alt='Vote down' />
                                    <span id='downVoteScore'><img  src='images/loader.png'  /></span>
                                </span>
                            </div>
                        </li>
                    </ul>
                    <form id="insertVote">

                        <div data-role="content" style="display:none;">
                            <div data-role="fieldcontain">

                                <input type="text" name="poiId" id="poiIdForVote" required />
                            </div>
                            <div data-role="fieldcontain">

                                <input type="text" name="poiVote" id="poiVote" required/>
                            </div>
                        </div><!--list-scroll-container-->
                    </form>

                </div><!--list-container-->

                <footer data-role="footer" data-posistion="fixed" data-fullscreen="true">
                    <a href="" id="addFav" data-icon="star" data-theme="a" title="Add to favourites" data-rel="star" class="ui-btn-center">Add to favourites</a>
                    <a href="" id="removeFav" data-icon="star" data-theme="a" title="Remove from favourites" data-rel="star" class="ui-btn-center">Remove from favourites</a>
                </footer>

            </div>
        </div><!-- /page -->

        <script type="text/javascript">

            /****************** Global js vars ************************/
            /* GLobal map object */
            var map;
            /* List of pois read from json object */
            var pois = [];
            /* List of dataset metadata read from json object */
            var meta = {};
            /* Holds all markers */
            var markersArray = [];
            /* Holds filters */
            var filters = [];

            /*The id (unique identifier) of the application*/
            var appId = "<?php echo $appID; ?>";

            /* Keeps page id to emulate full url using querystring */
            var pageId = 0;

            /* Set infoBubble/infoWindow global variable */
            var infoBubble;

            /* Defines the color of the infoBubble/infoWindow*/
            var bubbleColor = <?php echo "'" . $colors['darkColor'] . "'" ?>;
            
            
             <?php 
            //echo 'datasetPreview = ';
            if(isset($_GET['preview']))
            {
                echo 'var datasetPreview = true;';   
                 echo 'var datasetPreviewId = "'. $_GET['converterdatasetID'] .'";';  
                echo   'var cities = "";';
                echo 'var appName= "Dataset Preview";';
                
            }
            else
            {
                echo 'var datasetPreview = false;';
                 echo 'var datasetPreviewId = -1;';  
                echo   'var cities =' ;
                echo  printSelectedCities($appID) . ";"; 
                Database::connect();
                echo 'var appName= "' . App::createFromDb($_GET['uid'])->name . '";';
                Database::disconnect();
            } ?>
            
                

            /* The coordinates of the center of the map */
            var mapLat = <?php echo MAP_CENTER_LATITUDE; ?>;
            var mapLon = <?php echo MAP_CENTER_LONGITUDE; ?>;
            var mapZoom = <?php echo MAP_ZOOM; ?>;
            var maxCityDistance = <?php echo MAX_CITY_DISTANCE_KM; ?>;

            var insertNewPoiScript = "<?php echo SERVERNAME . BASE_DIR . CLASSES_DIR . "insert.php"; ?>";
            var insertNewVoteScript = "<?php echo SERVERNAME . BASE_DIR . CLASSES_DIR . "voteManager.php"; ?>";
            var getPoiVotesScript = "<?php echo SERVERNAME . BASE_DIR . CLASSES_DIR . "voteManager.php"; ?>";


            /* Just call the initialization function when the page loads */
            $(window).load(function() {
                globalInit();
            });

        </script>
    </body>
</html>