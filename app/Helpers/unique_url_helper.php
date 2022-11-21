<?php 
function create_unique_url($table,$url,$id = "")
{
    $i = 0;
    $params = array ();
    $params['url'] = $url;
    if ($id != "") {
        $params[] = ['id','!=',$id];
    }

    while (DB::table($table)->where($params)->count())
    {
        if (!preg_match ('/-{1}[0-9]+$/', $url )) {
            $url .= '-' . ++$i;
        } else {
            $url = preg_replace ('/[0-9]+$/', ++$i, $url );
        }
        $params['url'] = $url;
    }
    
    return $url;
}

function create_unique_product_number($product_number,$product_id="")
{
    $i = 0;
    $params = array ();
    $params['product_number'] = $product_number;
    if ($product_id != "") {
        $params['id !='] = $product_id;
    }

    while (DB::table('products')->where($params)->get()->count())
    {
        if (!preg_match ('/-{1}[0-9]+$/', $product_number )) {
            $product_number .= '-' . ++$i;
        } else {
            $product_number = preg_replace ('/[0-9]+$/', ++$i, $product_number );
        }
        $params ['product_number'] = $product_number;
    }
    
    return $product_number;
}

function getTranslation($from_lang,$to_lang,$segment)
{

    if($from_lang == $to_lang)
        return url()->current();
    
    if(Request::segment(2) == __('routes.page'))
    {
        $page = DB::table('page_translations')->where('url',$segment)->get()->first();

        if($page !== NULL)
        {
            $page_translation = DB::table('page_translations')->where('page_id',$page->page_id)->where('lang',$to_lang)->get()->first();
            return isset($page_translation->url) ? url($to_lang.'/'.__('routes.page',[],$to_lang).'/'.$page_translation->url) : url($to_lang);
        }
        else
            return url($to_lang);
    }

    if(Request::segment(2) == __('routes.contact'))
    {
        return url($to_lang.'/'.__('routes.contact',[],$to_lang));
    }

    if(Request::segment(2) == __('routes.blog'))
    {
        return url($to_lang.'/'.__('routes.blog',[],$to_lang));
    }

    if($segment == "")
        return url($to_lang);


    return url($to_lang);
}