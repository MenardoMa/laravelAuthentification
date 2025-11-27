<?php

namespace App\Livewire\Admin;

use App\Models\GeneralSettings;
use Livewire\Component;

class GeneralSetting extends Component
{
    public $tab = null;

    public $tab_default = 'setting_general';

    protected $queryString = ['tab' => ['keep' => true]];

    public $site_title, $site_email, $site_phone_number, $site_meta_keywords, $site_description;

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = Request('tab') ? Request('tab') : $this->tab_default;
    }

    public function GeneralSetting()
    {
        $setting = GeneralSettings::take(1)->first();

        if (!is_null($setting)) {

            $this->site_title = $setting->site_title;
            $this->site_email = $setting->site_email;
            $this->site_phone_number = $setting->site_phone_number;
            $this->site_meta_keywords = $setting->site_meta_keywords;
            $this->site_description = $setting->site_description;

        }

    }

    public function render()
    {
        return view('livewire.admin.general-setting');
    }
}
