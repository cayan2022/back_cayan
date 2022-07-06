<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasActivation
{
    public function isActive():bool
    {
        return $this->is_block === false;
    }
    public function isBlock():bool
    {
        return $this->is_block === true;
    }
    public function block(?User $user=null):void
    {
        if (isset($user)){
            $user->update(['is_block'=>true]);
        }else{
            $this->update(['is_block'=>true]);
        }
    }
    public function active(?User $user=null):void
    {
        if (isset($user)){
            $user->update(['is_block'=>false]);
        }else{
            $this->update(['is_block'=>false]);
        }
    }
    public function toggleActivation(?User $user=null):void
    {
        if (isset($user)){
            $user->isActive() ? $user->block() : $user->active();
        }else{
            $this->isActive() ? $this->block() : $this->active();
        }
    }
}
