<?php

namespace Fully\Repositories\Setting;

use Fully\Models\Setting;
use Fully\Repositories\AbstractValidator as Validator;
use Config;
use File;
use Image;

/**
 * Class SettingRepository.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class SettingRepository extends Validator implements SettingInterface
{
    /**
     * @var \Setting
     */
    protected $setting;
    protected $width;
    protected $height;
    protected $thumbWidth;
    protected $thumbHeight;
    protected $imgDir;

    /**
     * @param Setting $setting
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
        $config = Config::get('fully');
        $this->width = $config['modules']['setting']['image_size']['width'];
        $this->height = $config['modules']['setting']['image_size']['height'];
        $this->thumbWidth = $config['modules']['setting']['thumb_size']['width'];
        $this->thumbHeight = $config['modules']['setting']['thumb_size']['height'];
        $this->imgDir = $config['modules']['setting']['image_dir'];
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        $obj = ($this->setting->where('lang', getLang())->first()) ?: $this->setting;

        $jsonData = $obj->settings;
        $setting = json_decode($jsonData, true);

        if ($setting === null) {
            $setting = array(
                'site_title' => null,
                'ga_code' => null,
                'meta_keywords' => null,
                'meta_description' => null,
                'path'=>null,
                'file_name'=>null,
                'file_size'=>null
            );
        }

        return $setting;
    }
    public function update($attributes)
    {
        $setting = (Setting::where('lang', getLang())->first()) ?: new Setting();

        //-------------------------------------------------------

        $file = null;

        if (isset($attributes['image'])) {
            $file = $attributes['image'];
        }

        if ($file) {
            $destinationPath = public_path().$this->imgDir;
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getClientSize();

            $upload_success = $file->move($destinationPath, $fileName);

            if ($upload_success) {

                // resizing an uploaded file
                Image::make($destinationPath.$fileName)->resize($this->width, $this->height)->save($destinationPath.$fileName);

                // thumb
                Image::make($destinationPath.$fileName)->resize($this->thumbWidth, $this->thumbHeight)->save($destinationPath.'thumb_'.$fileName);

                $attributes['file_name'] = $fileName;
                $attributes['file_size'] = $fileSize;
                $attributes['path'] = $this->imgDir;
            }
        }
        unset($attributes['_token']);
        $json = json_encode($attributes);
        $setting->fill(array('settings' => $json, 'lang' => getLang()))->save();
        return true;
    }
}
