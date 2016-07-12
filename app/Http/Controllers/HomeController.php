<?php

namespace Fully\Http\Controllers;

use Fully\Repositories\Project\ProjectInterface;
use Fully\Repositories\Slider\SliderInterface;
use Fully\Repositories\Tag\TagInterface;
use Fully\Repositories\Page\PageInterface;
use LaravelLocalization;

/**
 * Class HomeController.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class HomeController extends Controller
{
    protected $slider;
    protected $project;
    protected $tag;
    protected $page;

    public function __construct(SliderInterface $slider, ProjectInterface $project, TagInterface $tag,PageInterface $page)
    {
        $this->slider = $slider;
        $this->project = $project;
        $this->tag = $tag;
        $this->page =$page;
    }

    public function index()
    {
        $languages = LaravelLocalization::getSupportedLocales();

        $sliders = $this->slider->all();
        $projects = $this->project->all();
        $tags = $this->tag->all();
        $home_our_clients_say=$this->page->pairing_page(3);
        return view('frontend/layout/dashboard', compact('sliders', 'projects', 'languages', 'tags','home_our_clients_say'));
    }
}
