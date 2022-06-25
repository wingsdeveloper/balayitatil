<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
@php echo "<?xml-stylesheet href='" . asset('xml/xml.xsl') . "'  type='text/xsl'?>" @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">


    @foreach($pivot as $pivotkey => $row)

        @if($pivotkey == 'website_panel_blog_category_pages')

            @foreach($row as $pagerow)
                <url>
                    <loc>{{ route('category.detail', [$pivot['website_panel_blog_category_ana_kategori']->link, $pagerow->seo_url]) }}/</loc>
                    <lastmod>{{ date('2021-01-d', strtotime($pagerow->updated_at)) }}</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.8</priority>
                </url>
            @endforeach
            @continue
        @endif


        @foreach($row as $key => $inrow)
            @continue(!$inrow->seo_url)

            @if($inrow->pivot == 'website_panel_categories')

            @elseif($inrow->pivot == 'website_panel_blogs')
                <url>
                    <loc>{{ route('blog.control', [$inrow->seo_url]) }}/</loc>
                    <lastmod>{{ date('2021-01-d', strtotime($inrow->updated_at)) }}</lastmod>
                    <changefreq>monthly</changefreq>
                    <priority>0.8</priority>
                </url>
            @elseif($inrow->pivot == 'website_panel_extras')
                <url>
                    <loc>{{ route('extra.detail', [$inrow->seo_url]) }}/</loc>
                    <lastmod>{{ date('2021-01-d', strtotime($inrow->updated_at)) }}</lastmod>
                    <changefreq>monthly</changefreq>
                    <priority>0.4</priority>
                </url>
            @elseif($inrow->seo_url == "kiralik-villa")
                    @if(!isset($counter))
                        <url>
                            <loc>{{ route('home') }}</loc>
                            <lastmod>{{ date('2021-01-d') }}</lastmod>
                            <changefreq>daily</changefreq>
                            <priority>1.0</priority>
                        </url>
                        @php($counter=1)
                    @endif
                <url>
                    <loc>{{ route('static', $inrow->seo_url) }}/</loc>
                    <lastmod>{{ date('2021-01-d', strtotime($inrow->updated_at)) }}</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.8</priority>
                </url>
            @elseif($inrow->pivot == 'website_panel_area_contents')
                <url>
                    <loc>{{ route('static', $inrow->seo_url) }}/</loc>
                    <lastmod>{{ date('2021-01-d', strtotime($inrow->updated_at)) }}</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.8</priority>
                </url>
            @else

                <url>
                    <loc>{{ route('static', $inrow->seo_url) }}/</loc>
                    <lastmod>{{ date('2021-01-d', strtotime($inrow->updated_at)) }}</lastmod>
                    <changefreq>never</changefreq>
                    <priority>0.8</priority>
                </url>
            @endif

        @endforeach



    @endforeach

</urlset>
