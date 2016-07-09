<?php

namespace Fully\Models;

/**
 * Class Page.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class LanguageData extends BaseModel
{

    public $timestamps = false;
    public $table = 'language_data';
    protected $fillable = ['type','lang_data_id','lang','pairing_id'];
    public function Page()
    {
        return $this->hasOne('Fully\Models\Page','id','lang_data_id');
    }
}
