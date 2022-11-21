<?php

/**
 * Legördülő lista készítő függvény
 * @param string $table             - tába neve amelyből készül a legördülő
 * @param string $select_name       - a legördülő lista neve (pl. unit, vagy többszörös legördülő esetén categories[])
 * @param string $option_value      - a táblában lévő mező neve amely az opció értéke lesz
 * @param string $option            - a táblában lévő mező neve amely az opció neve lesz
 * @param string $js                - ha true - az űrlap köldésre kerül az opció kiválasztása után
 * @param string $multiselect       - ha true - többszörös legördülő
 * @param string $selected_value    - a kiválasztott érték
 * @param string $first_value       - az első érték
 * @param string $where             - feltétel pl. ['id',1]
 */
function custom_select($table="pages",$select_name="page_id",$option_value='id', $option='name',$js = false,$multiselect = false,$selected_value=false,$first_value="",$where="")
{

    if($js !== false && is_bool($js))
        $js = "onchange='this.form.submit();'";
    $id = str_replace('id','',$select_name);


    $attributes = "";
    $attributes.=" class='form-select select2 input-sm'";
    $attributes.=" id='".$select_name."_id'";
    $attributes.= $js;

    $value = array();

    $values = DB::table($table)
                    ->when($where, function ($query, $where) {
                        return $query->where($where[0], $where[1]);
                    })
                ->get()->pluck($option, $option_value);

    if(!empty($first_value))
    {
        if (is_array($first_value))
        {
            $value = $first_value;
        }
        else
            $value[''] = $first_value;
    }

    foreach($values as $id => $v)
    {
        $value[$id] = $v;
    }

    $default_selected_value = '';
    if($selected_value === false)
    {
        $post = !empty($_POST[$select_name]) ? $_POST[$select_name] : '';
        $selected_value = !empty($post) ? $post :$default_selected_value;
    }

    $ms = $multiselect === true ? 'multiple' : '';

    $ret = '';

    $ret .= '<select name="'.$select_name.'" '.$attributes.' '.$ms.' >';
    if(!empty($value))
    {
        foreach($value as $id => $item)
        {
            if(is_array($selected_value))
                $selected = in_array($id,$selected_value) ? 'selected' : '';
            else
                $selected = $selected_value == $id ? 'selected' : '';
            $ret .= '<option value="'.$id.'" '.$selected.'>'.$item.'</option>';
        }
    }
    $ret .= '</select>';
    return $ret;
}

function category_select_options($categories, $selected_categories = array(), $prefix = '-')
{
    if(empty($categories))
        return "";
    
    $options = "";
    
    foreach ($categories as $key => $category)
    {
        $name = $category->translation->name ?? $category->name;
        $selected = in_array($category->id,$selected_categories) ? 'selected' : '';

        $options .= '<option value="'.$category->id.'" '.$selected.'>'.$prefix.' '.$name.'</option>';

        if(!empty($category->children))
            $options .= category_select_options($category->children,$selected_categories,$prefix.'-');
    }

    return $options;
}


function category_select($categories,$selected_categories=array(),$multiple='',$required='',$id="category_id")
{
    if(empty($categories))
        return "";

    $html = '<select name="categories[]" class="form-select select2" '.$multiple.' '.$required.' id="'.$id.'">';
    if($required == '')
        $html .= '<option value="">'.__('please_select').'...</option>';
    $html .= category_select_options($categories, $selected_categories, $prefix = '-');
    $html .= '</select>';

    return $html;
}

function parseTemplate($template,$datas)
{
    $pattern = '{%s}';
    foreach($datas as $key=>$val){
        $varMap[sprintf($pattern,$key)] = $val;
    }
    return strtr($template,$varMap);
}
