<?php

namespace Fully\Repositories\Slider;

use Fully\Models\Slider;
use Fully\Repositories\AbstractValidator as Validator;
use Fully\Exceptions\Validation\ValidationException;
use Config;
use Image;

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
    protected $width;
    protected $height;
    protected $imgDir;

    protected static $rules = [
        'title' => 'required|min:10',
        'description' => 'required|min:10',
        'link'=>'required|url',
        'target'=>'required|in:_blank,_self',
        'image'=>'required|image|max:4000'
    ];
    protected static $attributeNames=
        [
            'title' => 'Title',
            'description' => 'Description',
            'link'=>'Link',
            'target'=>'Target',
            'image'=>'Image'
        ];
    /**
     * @param Slider $slider
     */
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;

        $config = Config::get('fully');
        $this->width = $config['modules']['slider']['image_size']['width'];
        $this->height = $config['modules']['slider']['image_size']['height'];
        $this->imgDir = $config['modules']['slider']['image_dir'];
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
    public function create($attributes){
        if (!$this->isValid($attributes)) {
            throw new ValidationException('Slide validation failed', $this->getErrors());
        }
        $slider = new Slider();
        $upload_success = null;
        if (isset($attributes['image'])) {
            $file = $attributes['image'];

            $destinationPath = public_path().$this->imgDir;
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getClientSize();

            $upload_success = $file->move($destinationPath, $fileName);

            // resizing an uploaded file
            Image::make($destinationPath.$fileName)->resize($this->width, $this->height)->save($destinationPath.$fileName);

            $slider->file_name = $fileName;
            $slider->file_size = $fileSize;

            $slider->path = $this->imgDir.$fileName;

        }
        $slider->title = $attributes['title'];
        $slider->description = $attributes['description'];
        $slider->target = $attributes['target'];
        $slider->link = $attributes['link'];
        $slider->lang = getLang();
        $slider->save();
        return true;
    }
    public function update($id, $attributes){
        $slider = Slider::findOrFail($id);

        if (isset($attributes['image'])) {
            if ($file = $attributes['image']) {
                // delete old image
                $destinationPath = public_path().$this->imgDir;
                File::delete($destinationPath.$slider->file_name);

                $destinationPath = public_path().$this->imgDir;
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getClientSize();

                $upload_success = $file->move($destinationPath, $fileName);

                if ($upload_success) {

                    // resizing an uploaded file
                    Image::make($destinationPath.$fileName)->resize($this->width, $this->height)->save($destinationPath.$fileName);

                    $slider->file_name = $fileName;
                    $slider->file_size = $fileSize;
                    $slider->path = $this->imgDir.$fileName;
                }
            }
        }
        $slider->title = $attributes['title'];
        $slider->description = $attributes['description'];
        $slider->target = $attributes['target'];
        $slider->link = $attributes['link'];
        $slider->save();
        return true;
    }
}
