<?php

namespace Fully\Repositories\Slider;

use Fully\Models\Slider;
use Fully\Repositories\AbstractValidator as Validator;

/**
 * Class SliderRepository.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class SliderRepository extends Validator implements SliderInterface
{
    /**
     * @var \Slider
     */
    protected $slider;

    /**
     * @param Slider $slider
     */
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->slider->where('lang', getLang())->orderBy('created_at', 'DESC')->get();
    }

    public function paginate($page = 1, $limit = 10, $all = false)
    {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->slider->orderBy('created_at', 'DESC')->where('lang', getLang());

        $sliders = $query->skip($limit * ($page - 1))->take($limit)->get();

        $result->totalItems = $this->totalSliders($all);
        $result->items = $sliders->all();

        return $result;
    }
    protected function totalSliders($all = false)
    {

        if (!$all) {
            return $this->slider->where('lang', getLang())->count();
        }

        return $this->slider->where('lang', getLang())->count();
    }

}
