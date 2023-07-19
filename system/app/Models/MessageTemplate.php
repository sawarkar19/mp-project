<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    public function type(){
        return $this->hasOne('App\Models\MessageType', 'id', 'type_id');
    }

    public function scopeWishingTemplates($query, $message_template_category_id)
    {
        if ($message_template_category_id!='') {
            $query->where(function ($query) use ($message_template_category_id) {
                if($message_template_category_id == '7' || $message_template_category_id == '8'){
                    $query->where('message_templates.message_template_category_id', $message_template_category_id );
                }
                // else if($message_template_category_id == '7'){
                //     $query->where('message_templates.message_template_category_id', $message_template_category_id );
                // }
                // else if($message_template_category_id != '2' || $message_template_category_id != '5' || $message_template_category_id != '6' ){
                //     $query->where('message_templates.message_template_category_id', $message_template_category_id );
                // }                
            });
        }
        return $query;
    }

    public function scopePersonalisedTemplates($query)
    {    
        $query->where('message_templates.message_template_category_id ', '!=', '6' )
        ->where('message_templates.type_id', '<>', '5' )
        ->where('message_templates.type_id', '<>', '2' );
        return $query;
    }

    public function category(){
        return $this->belongsTo('App\Models\MessageTemplateCategory', 'message_template_category_id', 'id');
    }
}
