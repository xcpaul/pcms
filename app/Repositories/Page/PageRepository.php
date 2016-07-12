<?php

namespace Fully\Repositories\Page;

use Fully\Models\Page;
use Fully\Models\LanguageData;
use Config;
use Response;
use LaravelLocalization;
use Fully\Repositories\RepositoryAbstract;
use Fully\Repositories\CrudableInterface as CrudableInterface;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class PageRepository.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class PageRepository extends RepositoryAbstract implements PageInterface, CrudableInterface
{
    /**
     * @var
     */
    protected $perPage;
    /**
     * @var \Page
     */
    protected $page;
    /**
     * Rules.
     *
     * @var array
     */
    protected $translator;
    protected static $rules = [
        'title' => 'required|min:10',
        'content' => 'required|min:50', ];
    protected static $attributeNames=
    [

    ];
    /**
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
        $this->page = $page;

        $lan_rules=array();
        $attributeNames=array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){

            $attrbutes=array('title','content');

            $title_key='title.'.$localeCode;
            $content_key='content.'.$localeCode;

            $lan_rules[$title_key]='required|min:3';
            $lan_rules[$content_key]='required|min:5';

            foreach($attrbutes as $attrbute){
                $key = "validation.attributes.".$attrbute;
                if (($line = trans($key)) !== $key) {
                    $attributeNames[$attrbute.'.'.$localeCode]=$line;
                }
            }
        }
        static::$rules=$lan_rules;
        static::$attributeNames=$attributeNames;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->page->where('lang', $this->getLang())->get();
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug, $isPublished = false)
    {
        if ($isPublished === true) {
            return $this->page->where('slug', $slug)->where('is_published', true)->first();
        }

        return $this->page->where('slug', $slug)->first();
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        return $this->page->where('lang', $this->getLang())->lists('title', 'id');
    }

    /**
     * Get paginated pages.
     *
     * @param int  $page  Number of pages per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->page->orderBy('created_at', 'DESC')->where('lang', $this->getLang())->with('LanguageData');

        if (!$all) {
            $query->where('is_published', 1);
        }

        $pages = $query->skip($limit * ($page - 1))->take($limit)->get();

        $result->totalItems = $this->totalPages($all);
        $result->items = $pages->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->page->find($id);
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes)
    {
        $lang_attributes=array();
        if (!$this->isValid($attributes)) {
            throw new ValidationException('Page validation failed', $this->getErrors());
        }
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $lang_attribute=array();
            foreach($attributes as $name=>$attribute){
                $lang_attribute[$name]=isset($attribute[$localeCode])?$attribute[$localeCode]:'';
            }
            $lang_attribute['is_published'] = isset($attributes['is_published'][$localeCode]) ? true : false;
            $lang_attributes[$localeCode]=$lang_attribute;
        }
        $pairing_id_news=LanguageData::whereType('PAGE')->max('pairing_id');
        $pairing_id_news=$pairing_id_news?$pairing_id_news+1:1;

        $page_ids=[];

        foreach($lang_attributes as $lang_localeCode=> $lang_attribute){
                $page=new Page;
                $page->lang =$lang_localeCode;
                $page->fill($lang_attribute);
                $page->fill($lang_attribute)->save();
                $page_ids[$lang_localeCode]=$page->id;

        }
        foreach($page_ids as $lang=>$page_id){
            $language_data=new LanguageData;
            $language_data->type='PAGE';
            $language_data->lang_data_id=$page_id;
            $language_data->lang=$lang;
            $language_data->pairing_id=$pairing_id_news;
            $language_data->save();
        }

        return true;
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function update($id, $attributes)
    {
        $lang_attributes=array();
        if (!$this->isValid($attributes)) {
            throw new ValidationException('Page validation failed', $this->getErrors());
        }
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $lang_attribute=array();
            foreach($attributes as $name=>$attribute){
                $lang_attribute[$name]=isset($attribute[$localeCode])?$attribute[$localeCode]:'';
            }
            $lang_attribute['is_published'] = isset($attributes['is_published'][$localeCode]) ? true : false;

            $lang_attributes[$localeCode]=$lang_attribute;
        }

        foreach($lang_attributes as $lang_localeCode=> $lang_attribute){
            if(!isset($lang_attribute['id'])){
                throw new ValidationException('Page validation failed', $this->getErrors());
            }
            $page=new Page;
            $page = $this->find($lang_attribute['id']);
            $page->fill($lang_attribute)->save();
        }

        return true;
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id)
    {
        $page_find=$this->page->findOrFail($id);
        if($page_find&&$page_find->LanguageData->permanent===0){
            $languageDatas=LanguageData::whereType('PAGE')->wherePairing_id($page_find->LanguageData->pairing_id)
                ->with('Page')->get();
            foreach($languageDatas as $languageData){
                $languageData->delete();
                $languageData->Page->delete();
            }
        }else{
            return false;
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id)
    {
        $page = $this->page->find($id);
        $page->is_published = ($page->is_published) ? false : true;
        $page->save();

        return Response::json(array('result' => 'success', 'changed' => ($page->is_published) ? 1 : 0));
    }

    /**
     * Get total page count.
     *
     * @param bool $all
     *
     * @return mixed
     */
    protected function totalPages($all = false)
    {
        if (!$all) {
            return $this->page->where('is_published', 1)->where('lang', $this->getLang())->count();
        }

        return $this->page->where('lang', $this->getLang())->count();
    }
    public function pairing_page($pairing_id,$lang=NULL){
        if($lang===NULL){
            $lang=getLang();
        }
        $languageData=LanguageData::whereType('PAGE')->wherePairing_id($pairing_id)->
            whereHas('Page', function($q) use($lang)
            {
                $q->whereLang($lang);

            })->get()->first();
        $page=$languageData?$languageData->Page:false;
        return $page;
    }
}
