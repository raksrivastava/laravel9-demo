<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
           // 'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'email' => $this->email,
          //  'created_at' => $this->created_at->format('d/m/Y'),
           // 'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }

}
