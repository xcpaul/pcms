<?php

namespace Fully\Http\Controllers\Admin;

use Fully\Http\Controllers\Controller;
use Fully\Repositories\Setting\SettingInterface;
use Redirect;
use View;
use Input;
use Flash;
use Fully\Models\Setting;

/**
 * Class SettingController.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class SettingController extends Controller
{
    protected $setting;

    public function __construct(SettingInterface $setting)
    {
        $this->setting = $setting;
    }
    public function index()
    {
        $obj = (Setting::where('lang', getLang())->first()) ?: new Setting();

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
        return view('backend.setting.setting', compact('setting'))->with('active', 'settings');
    }

    public function save()
    {
       var_dump(Input::all());
        try {
            $this->setting->update(Input::all());
            Flash::message('Settings was successfully updated');

            return Redirect::route('admin.settings');
        } catch (ValidationException $e) {
            return Redirect::route('admin.settings')->withInput()->withErrors($e->getErrors());
        }
    }
}
