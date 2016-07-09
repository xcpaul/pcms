<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use Response;
use Fully\Models\LanguageData;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Page\PageInterface;
use Fully\Repositories\Page\PageRepository as Page;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class PageController.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class PageController extends Controller
{
    protected $page;
    protected $perPage;

    public function __construct(PageInterface $page)
    {
        View::share('active', 'modules');

        $this->page = $page;
        $this->perPage = config('fully.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pagiData = $this->page->paginate(Input::get('page', 1), $this->perPage, true);
        $pages = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        try {
            $this->page->create(Input::all());
            Flash::message('Page was successfully added');

            return langRedirectRoute('admin.page.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.page.create')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $page = $this->page->find($id);

        return view('backend.page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $languageData=LanguageData::whereType('PAGE')
            ->where('lang_data_id','=',$id)
            ->where('lang','=',getLang())->first();
        $pairing_id=$languageData?$languageData->pairing_id:NULL;
        $languageDatas=LanguageData::wherePairing_id($pairing_id)->whereType('PAGE')
            ->with('Page')->get();

        $pages_lang_data=array();
        foreach($languageDatas as $languageData){
            $page=$languageData->Page;
            $pages_lang_data[$page->lang]=$page;
        }
        $page = $this->page->find($id);
        return view('backend.page.edit', compact('pages_lang_data','page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        try {
            $this->page->update($id, Input::all());
            Flash::message('Page was successfully updated');

            return langRedirectRoute('admin.page.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.page.edit',array($id))->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if( $this->page->delete($id)){
            Flash::message('Page was successfully deleted');
            return langRedirectRoute('admin.page.index');
        }
        else{

            return langRedirectRoute('admin.page.index')->withErrors($this->page->msg);
        }
    }

    public function confirmDestroy($id)
    {
        $page = $this->page->find($id);

        return view('backend.page.confirm-destroy', compact('page'));
    }

    public function togglePublish($id)
    {
        return $this->page->togglePublish($id);
    }
}
