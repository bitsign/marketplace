<?php

namespace App\Models;

use App\Models\AttributeOption;
use App\Models\AttributeTranslation;
use App\Models\AttributeOptionTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Attribute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    //protected $fillable = [];

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))->where(['parent_id'=>0])->orderBy('sort')->get();
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('sort');
    }

    public function translation()
    {
        return $this->hasOne(AttributeTranslation::class)->where(['lang'=>app()->getLocale()]);
    }

    public function translations()
    {
        return $this->hasMany(AttributeTranslation::class);
    }

    public function attributeOptions()
    {
        return $this->hasMany(AttributeOption::class);
    }

    //admin functions

    public static function sortAttributes($items)
    {
        if(isset($items))
        {
            $row = 0;
            foreach ($items as $position=>$id)
            {
                $row += static::where('id',$id)->update(array('sort'=>$position));
            }
            return $row;
        }
        return 0;
    }

    public static function sortValues($items)
    {
        if(isset($items))
        {
            $row = 0;
            foreach ($items as $position=>$id)
            {
                $row += AttributeOption::where('id',$id)->update(array('sort'=>$position));
            }
            return $row;
        }
        return 0;
    }

    /*public static function attributeOptions($attribute_id)
    {
        return AttributeOption::where('attribute_id',$attribute_id)->orderBy('sort')->get();
    }*/

    public static function addOptionValues($id,$post)
    {
        $count = count($post['name'][app()->getLocale()]);
        $data = array();
        $rows = 0;
        for($i=0; $i<$count; $i++)
        {
            $posted = array();
            if(!empty($post['image'][$i]))
            {
                $img_ = explode('/',$post['image'][$i]);
                $posted['image'] = end($img_);
            }
            else
                $posted['image'] = "";

            $posted['params']       = $post['params'][$i];
            $posted['sort']         = $post['sort'][$i];
            $posted['attribute_id'] = $id;

            if(!empty($post['option_id']))
            {
                $attribute_option = AttributeOption::where('id', $post['option_id'][$i])->first();
                $attribute_option->fill($posted)->save();
                if($attribute_option->wasChanged())
                    $rows++;
            }
            else
            {
                $attribute_option = AttributeOption::create($posted);
            }

            foreach(config('app.available_locales') as $lang)
            {
                $translation_name = $post['name'][$lang][$i] ?? '';
                if(isset($post['opt_translation_id'][$lang][$i]) && $post['opt_translation_id'][$lang][$i] !== NULL)
                    $translation_exists = AttributeOptionTranslation::where('id', $post['opt_translation_id'][$lang][$i])->first();
                else
                    $translation_exists = array();

                if((!empty($translation_exists) &&  $translation_name != $translation_exists->name) || empty($translation_exists))
                    $translation_url = create_unique_url('attribute_option_translations',Str::slug($translation_name));
                else
                    $translation_url = $translation_exists->url;

                $translation['attribute_option_id'] = $attribute_option->id;
                $translation['url']                 = $translation_url;
                $translation['name']                = $translation_name;
                $translation['lang']                = $lang;

                if(isset($post['opt_translation_id'][$lang][$i]) && $post['opt_translation_id'][$lang][$i] !== NULL)
                {
                    $update = AttributeOptionTranslation::where('id', $post['opt_translation_id'][$lang][$i])->update($translation);
                    if($update > 0)
                        $rows++;
                }
                else
                {
                    $insert = AttributeOptionTranslation::create($translation);
                    if($insert->wasRecentlyCreated)
                        $rows++;
                }
            }
        }
        return $rows;
    }

    public static function deleteOptionValue($id)
    {
        return AttributeOption::where('id', $id)->delete();
    }

    public static function deleteOptionValues($attribute_id)
    {
        $options = AttributeOption::where('attribute_id', $attribute_id)->get();
        foreach($options as $o)
        {
            AttributeOptionTranslation::where('attribute_option_id', $o->id)->delete();
        }
        return AttributeOption::where('attribute_id', $attribute_id)->delete();

    }

    public static function getOptionsLike($str)
    {
        return AttributeOptionTranslation::where('name','LIKE','%'.$str.'%')->orderBy('name')->get();
    }

    public static function getOptionValues($attribute_id)
    {
        return AttributeOption::where('attribute_id','=',$attribute_id)->with('translation')->orderBy('sort','ASC')->get();
    }

}
