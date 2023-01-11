<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// This is the wakalah Model file;
class WakalahApplication extends Model implements HasMedia
{
    use InteractsWithMedia,HasFactory;
    protected $fillable = ['first_name', 'last_name', 'email', 'ic_number', 'phone', 'wakalah_type', 'address','institution_name', 'city', 'state', 'zip', 'bank_account', 'bank_name', 'files1', 'files2', 'files3', 'files4', 'status_id','affiliate_link','wakalah_id','rejection_reason','approval_by','approval_at'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
