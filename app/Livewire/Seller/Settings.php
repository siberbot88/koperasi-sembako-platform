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

    public $name;
    public $description;
    public $phone;
    public $address;
    public $city;
    public $logo;
    public $banner;
    public $existingLogo;
    public $existingBanner;
    public $operationalHours = [];

    protected $rules = [
        'name' => 'required|min:3|max:50',
        'description' => 'nullable|max:500',
        'phone' => 'nullable|numeric',
        'address' => 'nullable',
        'city' => 'nullable',
        'logo' => 'nullable|image|max:1024',
        'banner' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $store = auth()->user()->store;
        if ($store) {
            $this->name = $store->name;
            $this->description = $store->description;
            $this->phone = $store->phone;
            $this->address = $store->address;
            $this->city = $store->city;
            $this->existingLogo = $store->logo;
            $this->existingBanner = $store->banner;
            $this->operationalHours = $store->operational_hours ?: $this->defaultHours();
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
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'operational_hours' => $this->operationalHours,
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
            $data['seller_id'] = (string) $user->_id;
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
