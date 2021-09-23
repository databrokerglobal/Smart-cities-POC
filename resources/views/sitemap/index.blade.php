<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>{{route('home')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	@foreach ($communities as $community)
        <url>
            <loc>{{route('data_community.'.str_replace(' ', '_', strtolower($community->slug)))}}</loc>
            <changefreq>daily</changefreq>
            <priority>0.4</priority>
        </url>
    @endforeach
    @foreach ($communities as $community)
        <url>
            <loc>{{route('data.community_'.str_replace(' ', '_', strtolower($community->slug)))}}</loc>
            <changefreq>daily</changefreq>
            <priority>0.4</priority>
        </url>
    @endforeach
	<url>
		<loc>{{route('about.about')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('about.terms_conditions')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('about.privacy_policy')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('about.cookie_policy')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('about.matchmaking')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('about.media_center')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('about.partners')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('about.usecase')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('about.news')}}</loc>
        <changefreq>daily</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('contact')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('data_offer_publish')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('data_offer_start')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('help.overview')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('help.buying_data')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('help.selling_data')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('help.guarantee')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('help.file_complaint')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('help.send_file_complaint')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	<url>
		<loc>{{route('help.feedback')}}</loc>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	@foreach($buying_topics as $topic)
	<url>
		<loc>{{route('help.buying_data_topic', ['title'=>str_replace(' ', '-', strtolower($topic->title))])}}</loc>
        <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($topic->updated_at)) }}</lastmod>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	@endforeach
	@foreach($selling_topics as $topic)
	<url>
		<loc>{{route('help.selling_data_topic', ['title'=>str_replace(' ', '-', strtolower($topic->title))])}}</loc>
        <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($topic->updated_at)) }}</lastmod>
        <changefreq>weekly</changefreq>
		<priority>0.3</priority>
	</url>
	@endforeach    
    @foreach ($offers as $offer)
    	@php
    	$companyName = $offer['company_slug'];
		$title = $offer['offer_slug'];
		$region = "";
		foreach($offer['region'] as $key=>$r){
			$region = $region .$r->slug;
			if($key+1 < count($offer['region'])) $region = $region . "-";
		}
    	@endphp
        <url>
            <loc>{{route('data_details', ['companyName'=>$companyName, 'param'=>$title.'-'.$region])}}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($offer['updated_at'])) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach($themes as $theme)
        <url>
            <loc>{{route('data.offer_theme_filter', ['community'=>$theme->slug, 'theme'=>str_replace( ' ', '-', strtolower($theme->themeName))])}}</loc>			
            <changefreq>weekly</changefreq>
            <priority>0.3</priority>
        </url>
    @endforeach
    @foreach($communities as $community)
    	@foreach($regions as $region)
        <url>
            <loc>{{route('data.offer_region_filter', ['community'=>$community->slug, 'regionName'=>str_replace( ' ', '-', strtolower($region->regionName))])}}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.3</priority>
        </url>
    	@endforeach
    @endforeach
    @foreach ($companies as $company)
        <url>
            <loc>{{route('data.company_offers', ['companyName'=>$company['slug'] ])}}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($company['updated_at'])) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
	@foreach ($contents as $content)
        <url>
            <loc>{{$content->content_page_url}}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($content->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>