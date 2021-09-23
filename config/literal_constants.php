<?php

define('FIELDS_REQUIRED_MESSAGE',   'All fields marked with an asterisk are mandatory');

define('DATE_FORMAT',               'd M Y, h:i A');
define('SIMPLE_DATE',               'd M Y');
define('SIMPLE_DATETIME',           'd M Y h:i:s');
define('DB_DATE_FORMAT',            'Y-m-d');
define('DB_DATETIME_FORMAT',        'Y-m-d h:i:s');
define('CHART_DATE_FORMAT',         'M d');
define('HOUR24_DATETIME',           'd M Y H:i:s');
define('SORTABLE_DATE',             'Ymd');
define('SORTABLE_DATE_TIME',             'YmdHis');
define('STATUS',[0=>'Unpublished',1=>'Published']);
define('ACTIVE_STATUS',[0=>'Inactive',1=>'Active']);
define('IS_EMAIL_VERIFIED',[0=>'No',1=>'Yes']);
$years = range(1900,date('Y'));
define('YEAR_RANGE',array_combine($years,$years));
define('PARTNER_TYPE',[1=>'Technology partners',2=>'Integrators & resellers']);
$text_size = range(10,25);
define('TEXT_SIZE',array_combine($text_size,$text_size));
define('FONT_FAMILY',[
                    1=>'DM Sans', 
                    2=>'Arial', 
                    3=>'Roboto', 
                    4=>'Times New Roman', 
                    5=>'Times', 
                    6=>'Courier New', 
                    7=>'Courier', 
                    8=> 'RedHatDisplay']);
define('APPLIED_STATUS',[0=>'Not Applied',1=>'Applied']);

define('FIELD_SLUG_MESSAGE',   'Auto generated URL for SEO purpose. Only alphabets and numeric will be in URL. No special characters.');


// Image size constants 
// Offer Images

define ('OFFER_IMAGE_UPLOAD_PATH', 'uploads/offer');

define ('OFFER_LARGE_IMG_WIDTH',    1200);
define ('OFFER_LARGE_IMG_HEIGHT',   800); 

define ('OFFER_MEDIUM_IMG_WIDTH',   750); 
define ('OFFER_MEDIUM_IMG_HEIGHT',  500); 

define ('OFFER_TINY_IMG_WIDTH',     300); 
define ('OFFER_TINY_IMG_HEIGHT',    200); 

define ('OFFER_THUMB_IMG_WIDTH',    60); 
define ('OFFER_THUMB_IMG_HEIGHT',   40); 

// Home featured Data


define ('HOMEFEATURED_IMAGE_UPLOAD_PATH', 'uploads/home/featured_data');

define ('HOMEFEATURED_TINY_IMG_WIDTH',     300); 
define ('HOMEFEATURED_TINY_IMG_HEIGHT',    200); 

define ('HOMEFEATURED_THUMB_IMG_WIDTH',    80); 
define ('HOMEFEATURED_THUMB_IMG_HEIGHT',   40); 

define ('HOMEFEATURED_TINY_LOGO_WIDTH',     140); 
define ('HOMEFEATURED_TINY_LOGO_HEIGHT',    140); 

define ('HOMEFEATURED_THUMB_LOGO_WIDTH',    80); 
define ('HOMEFEATURED_THUMB_LOGO_HEIGHT',   80); 

// Home marketplace Data



define ('HOMEMARKETPLACE_IMAGE_UPLOAD_PATH', 'uploads/home/marketplace');

define ('HOMEMARKETPLACE_LARGE_IMG_WIDTH',    1200);
define ('HOMEMARKETPLACE_LARGE_IMG_HEIGHT',   800); 

define ('HOMEMARKETPLACE_MEDIUM_IMG_WIDTH',   750); 
define ('HOMEMARKETPLACE_MEDIUM_IMG_HEIGHT',  500); 

define ('HOMEMARKETPLACE_TINY_IMG_WIDTH',     300); 
define ('HOMEMARKETPLACE_TINY_IMG_HEIGHT',    200); 

define ('HOMEMARKETPLACE_THUMB_IMG_WIDTH',    60); 
define ('HOMEMARKETPLACE_THUMB_IMG_HEIGHT',   40); 

define ('HOMEMARKETPLACE_TINY_LOGO_WIDTH',     140); 
define ('HOMEMARKETPLACE_TINY_LOGO_HEIGHT',    140); 

define ('HOMEMARKETPLACE_THUMB_LOGO_WIDTH',    80); 
define ('HOMEMARKETPLACE_THUMB_LOGO_HEIGHT',   80); 


// Home teampicks Data



define ('HOMETEAMPICKS_IMAGE_UPLOAD_PATH', 'uploads/home/teampicks');

define ('HOMETEAMPICKS_LARGE_IMG_WIDTH',    1200);
define ('HOMETEAMPICKS_LARGE_IMG_HEIGHT',   800); 

define ('HOMETEAMPICKS_MEDIUM_IMG_WIDTH',   750); 
define ('HOMETEAMPICKS_MEDIUM_IMG_HEIGHT',  500); 

define ('HOMETEAMPICKS_TINY_IMG_WIDTH',     300); 
define ('HOMETEAMPICKS_TINY_IMG_HEIGHT',    200); 

define ('HOMETEAMPICKS_THUMB_IMG_WIDTH',    60); 
define ('HOMETEAMPICKS_THUMB_IMG_HEIGHT',   40); 

define ('HOMETEAMPICKS_TINY_LOGO_WIDTH',     140); 
define ('HOMETEAMPICKS_TINY_LOGO_HEIGHT',    140); 

define ('HOMETEAMPICKS_THUMB_LOGO_WIDTH',    80); 
define ('HOMETEAMPICKS_THUMB_LOGO_HEIGHT',   80); 

// usecases Data

define ('USECASES_IMAGE_UPLOAD_PATH', 'uploads/usecases');

define ('USECASES_LARGE_IMG_WIDTH',    1200);
define ('USECASES_LARGE_IMG_HEIGHT',   800); 

define ('USECASES_MEDIUM_IMG_WIDTH',   750); 
define ('USECASES_MEDIUM_IMG_HEIGHT',  500); 

define ('USECASES_TINY_IMG_WIDTH',     300); 
define ('USECASES_TINY_IMG_HEIGHT',    200); 

define ('USECASES_THUMB_IMG_WIDTH',    60); 
define ('USECASES_THUMB_IMG_HEIGHT',   40); 

// media Data

define ('MEDIA_IMAGE_UPLOAD_PATH', 'images/gallery/thumbs');

define ('MEDIA_LARGE_IMG_WIDTH',    1200);
define ('MEDIA_LARGE_IMG_HEIGHT',   800); 

define ('MEDIA_MEDIUM_IMG_WIDTH',   750); 
define ('MEDIA_MEDIUM_IMG_HEIGHT',  500); 

define ('MEDIA_TINY_IMG_WIDTH',     300); 
define ('MEDIA_TINY_IMG_HEIGHT',    200); 

define ('MEDIA_THUMB_IMG_WIDTH',    60); 
define ('MEDIA_THUMB_IMG_HEIGHT',   40); 

// communities Data

define ('COMMUNITIES_IMAGE_UPLOAD_PATH', 'uploads/communities');

define ('COMMUNITIES_LARGE_IMG_WIDTH',    1200);
define ('COMMUNITIES_LARGE_IMG_HEIGHT',   800); 

define ('COMMUNITIES_MEDIUM_IMG_WIDTH',   750); 
define ('COMMUNITIES_MEDIUM_IMG_HEIGHT',  500); 

define ('COMMUNITIES_TINY_IMG_WIDTH',     300); 
define ('COMMUNITIES_TINY_IMG_HEIGHT',    200); 

define ('COMMUNITIES_THUMB_IMG_WIDTH',    60); 
define ('COMMUNITIES_THUMB_IMG_HEIGHT',   40); 

//


define ('COMMUNITIES_DISCOVER_IMAGE_UPLOAD_PATH', 'uploads/communities/discover');

define ('COMMUNITIES_DISCOVER_LARGE_IMG_WIDTH',    1200);
define ('COMMUNITIES_DISCOVER_LARGE_IMG_HEIGHT',   800); 

define ('COMMUNITIES_DISCOVER_MEDIUM_IMG_WIDTH',   750); 
define ('COMMUNITIES_DISCOVER_MEDIUM_IMG_HEIGHT',  500); 

define ('COMMUNITIES_DISCOVER_TINY_IMG_WIDTH',     300); 
define ('COMMUNITIES_DISCOVER_TINY_IMG_HEIGHT',    200); 

define ('COMMUNITIES_DISCOVER_THUMB_IMG_WIDTH',    60); 
define ('COMMUNITIES_DISCOVER_THUMB_IMG_HEIGHT',   40); 

// teams Data

define ('TEAMS_IMAGE_UPLOAD_PATH', 'uploads/teams');

define ('TEAMS_LARGE_IMG_WIDTH',    1200);
define ('TEAMS_LARGE_IMG_HEIGHT',   800); 

define ('TEAMS_MEDIUM_IMG_WIDTH',   750); 
define ('TEAMS_MEDIUM_IMG_HEIGHT',  500); 

define ('TEAMS_TINY_IMG_WIDTH',     300); 
define ('TEAMS_TINY_IMG_HEIGHT',    200); 

define ('TEAMS_THUMB_IMG_WIDTH',    60); 
define ('TEAMS_THUMB_IMG_HEIGHT',   40); 

// partners Data

define ('PARTNERS_IMAGE_UPLOAD_PATH', 'uploads/partners');

define ('PARTNERS_LARGE_IMG_WIDTH',    1200);
define ('PARTNERS_LARGE_IMG_HEIGHT',   800); 

define ('PARTNERS_MEDIUM_IMG_WIDTH',   750); 
define ('PARTNERS_MEDIUM_IMG_HEIGHT',  500); 

define ('PARTNERS_TINY_IMG_WIDTH',     300); 
define ('PARTNERS_TINY_IMG_HEIGHT',    200); 

define ('PARTNERS_THUMB_IMG_WIDTH',    60); 
define ('PARTNERS_THUMB_IMG_HEIGHT',   40); 
// partners Data

define ('COMPANY_IMAGE_UPLOAD_PATH', 'uploads/company');

define ('COMPANY_LARGE_IMG_WIDTH',    500);
define ('COMPANY_LARGE_IMG_HEIGHT',   500); 

define ('COMPANY_MEDIUM_IMG_WIDTH',   215); 
define ('COMPANY_MEDIUM_IMG_HEIGHT',  215); 

define ('COMPANY_TINY_IMG_WIDTH',     70); 
define ('COMPANY_TINY_IMG_HEIGHT',    70); 

define ('COMPANY_THUMB_IMG_WIDTH',    40); 
define ('COMPANY_THUMB_IMG_HEIGHT',   40); 


// Home trending Data


define ('HOMETRENDING_IMAGE_UPLOAD_PATH', 'uploads/home/trending');

define ('HOMETRENDING_IMG_WIDTH',     60); 
define ('HOMETRENDING_IMG_HEIGHT',    60); 

define ('HOMETRENDING_TINY_IMG_WIDTH',     300); 
define ('HOMETRENDING_TINY_IMG_HEIGHT',    200); 

define ('HOMETRENDING_THUMB_IMG_WIDTH',    40); 
define ('HOMETRENDING_THUMB_IMG_HEIGHT',   40); 

define ('HOMETRENDING_TINY_LOGO_WIDTH',     140); 
define ('HOMETRENDING_TINY_LOGO_HEIGHT',    140); 

define ('HOMETRENDING_THUMB_LOGO_WIDTH',    80); 
define ('HOMETRENDING_THUMB_LOGO_HEIGHT',   80); 

// Theme Images

define ('THEMES_IMAGE_UPLOAD_PATH', 'uploads/themes');

define ('THEMES_LARGE_IMG_WIDTH',    1200);
define ('THEMES_LARGE_IMG_HEIGHT',   800); 

define ('THEMES_MEDIUM_IMG_WIDTH',   750); 
define ('THEMES_MEDIUM_IMG_HEIGHT',  500); 

define ('THEMES_TINY_IMG_WIDTH',     300); 
define ('THEMES_TINY_IMG_HEIGHT',    200); 

define ('THEMES_THUMB_IMG_WIDTH',    60); 
define ('THEMES_THUMB_IMG_HEIGHT',   40); 
?>