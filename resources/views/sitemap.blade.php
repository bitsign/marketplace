<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(count($pages) > 0)
        @foreach ($pages as $page)
            @php $url = $page->type == 'page' ? app()->getLocale() . '/' . __('routes.page') . '/' . $page->translation->url : app()->getLocale() . '/' . __('routes.' . $page->type); @endphp
            <url>
                <loc>{{ url($url) }}</loc>
                <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endif

    @if(count($posts) > 0)
        @foreach ($posts as $post)
            <url>
                <loc>{{ url(app()->getLocale().'/'.__('routes.post').'/'.$post->translation->url) }}</loc>
                <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endif

    @if(count($products) > 0)
        @foreach ($products as $product)
            <url>
                <loc>{{ url(app()->getLocale().'/'.__('routes.product').'/'.$product->translation->url) }}</loc>
                <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endif
</urlset>