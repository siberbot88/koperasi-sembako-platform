<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Store;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

#[Layout('layouts.seller')]
#[Title('Pengaturan Toko')]
class Settings extends Component
{
    use WithFileUploads;

    // Basic Info
    public $name;
    public $description;
    public $tagline;
    public $phone;
    public $email;
    public $whatsapp;
    public $address;
    public $city;
    public $province;
    public $postal_code;
    
    // Visual
    public $logo;
    public $banner;
    public $existingLogo;
    public $existingBanner;
    
    // Operational
    public $operationalHours = [];
    public $is_active = true;
    public $min_order = 0;
    public $free_shipping_min = 0;
    
    // Social Media
    public $facebook;
    public $instagram;
    public $twitter;
    public $tiktok;
    public $website;
    
    // Policies
    public $return_policy;
    public $shipping_policy;
    public $terms_conditions;

    protected $rules = [
        'name' => 'required|min:3|max:100',
        'tagline' => 'nullable|max:150',
        'description' => 'nullable|max:1000',
        'phone' => 'nullable|numeric',
        'email' => 'nullable|email',
        'whatsapp' => 'nullable|numeric',
        'address' => 'nullable|max:500',
        'city' => 'nullable|max:100',
        'province' => 'nullable|max:100',
        'postal_code' => 'nullable|max:10',
        'logo' => 'nullable|image|max:1024',
        'banner' => 'nullable|image|max:2048',
        'min_order' => 'nullable|numeric|min:0',
        'free_shipping_min' => 'nullable|numeric|min:0',
        'facebook' => 'nullable|url',
        'instagram' => 'nullable',
        'twitter' => 'nullable',
        'tiktok' => 'nullable',
        'website' => 'nullable|url',
        'return_policy' => 'nullable|max:2000',
        'shipping_policy' => 'nullable|max:2000',
        'terms_conditions' => 'nullable|max:2000',
    ];

    public function mount()
    {
        $store = auth()->user()->store;
        if ($store) {
            // Basic Info
            $this->name = $store->name;
            $this->tagline = $store->tagline;
            $this->description = $store->description;
            $this->phone = $store->phone;
            $this->email = $store->email;
            $this->whatsapp = $store->whatsapp;
            $this->address = $store->address;
            $this->city = $store->city;
            $this->province = $store->province;
            $this->postal_code = $store->postal_code;
            
            // Visual
            $this->existingLogo = $store->logo;
            $this->existingBanner = $store->banner;
            
            // Operational
            $this->operationalHours = $store->operational_hours ?: $this->defaultHours();
            $this->is_active = $store->is_active ?? true;
            $this->min_order = $store->min_order ?? 0;
            $this->free_shipping_min = $store->free_shipping_min ?? 0;
            
            // Social Media
            $this->facebook = $store->facebook;
            $this->instagram = $store->instagram;
            $this->twitter = $store->twitter;
            $this->tiktok = $store->tiktok;
            $this->website = $store->website;
            
            // Policies
            $this->return_policy = $store->return_policy;
            $this->shipping_policy = $store->shipping_policy;
            $this->terms_conditions = $store->terms_conditions;
        } else {
            $this->operationalHours = $this->defaultHours();
        }
    }

    private function defaultHours()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $hours = [];
        foreach ($days as $day) {
            $hours[$day] = ['open' => '08:00', 'close' => '20:00', 'is_closed' => false];
        }
        return $hours;
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();
        $store = $user->store;

        $data = [
            // Basic Info
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'tagline' => $this->tagline,
            'description' => $this->description,
            'phone' => $this->phone,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            
            // Operational
            'operational_hours' => $this->operationalHours,
            'is_active' => $this->is_active,
            'min_order' => $this->min_order ?? 0,
            'free_shipping_min' => $this->free_shipping_min ?? 0,
            
            // Social Media
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'tiktok' => $this->tiktok,
            'website' => $this->website,
            
            // Policies
            'return_policy' => $this->return_policy,
            'shipping_policy' => $this->shipping_policy,
            'terms_conditions' => $this->terms_conditions,
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('stores/logos', 'public');
        }

        if ($this->banner) {
            $data['banner'] = $this->banner->store('stores/banners', 'public');
        }

        if ($store) {
            $store->update($data);
        } else {
            $data['user_id'] = (string) $user->_id;
            $data['is_active'] = true;
            Store::create($data);
        }

        $this->dispatch('toast', message: 'Pengaturan toko berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.seller.settings');
    }
}
