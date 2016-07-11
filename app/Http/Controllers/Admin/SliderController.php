<?php

namespace Fully\Http\Controllers\Admin;

use Fully\Http\Controllers\Controller;
use View;
use Input;
use Fully\Models\Slider;
use Fully\Services\Pagination;
use Fully\Repositories\Slider\SliderInterface;
use Fully\Exceptions\Validation\ValidationException;
use Response;
use File;
use Image;
use Config;
use Flash;

/**
 * Class SliderController.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class SliderController extends Controller
{

    protected $slider;
    protected $perPage;

    public function __construct(SliderInterface $slider)
    {
        View::share('active', 'plugins');
        $this->slider=$slider;

        $this->perPage = config('fully.modules.slider.per_page');

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pagiData = $this->slider->paginate(Input::get('page', 1), $this->perPage, true);
        $sliders = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        return view('backend.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $this->slider->create(Input::all());
            Flash::message('Slide was successfully added');
            return langRedirectRoute('admin.slider.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.slider.create')->withInput()->withErrors($e->getErrors());
        }
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
        $slider = Slider::findOrFail($id);
        return view('backend.slider.edit', compact('slider'));
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
            $this->slider->update($id, Input::all());
            Flash::message('Slider was successfully updated');
            return langRedirectRoute('admin.slider.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.slider.edit',array($id))->withInput()->withErrors($e->getErrors());
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
        $slider = Slider::with('images')->findOrFail($id);
        $destinationPath = public_path().$this->imgDir;

        File::delete($destinationPath.$slider->file_name);
        $slider->delete();

        Flash::message('Slider was successfully deleted');

        return langRedirectRoute('admin.slider.index');
    }

    public function confirmDestroy($id)
    {
        $slider = Slider::findOrFail($id);

        return view('backend.slider.confirm-destroy', compact('slider'));
    }
}
