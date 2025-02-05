<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function add($user)
    {
       
        $this->preventTooManyUsers();

        $method = $user instanceof User ? 'save' : 'saveMany';

        return $this->members()->$method($user);
        
        // if($user instanceof User){
        //     return $this->members()->save($user);
        // }

        // return $this->members()->saveMany($user);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    public function preventTooManyUsers()
    {
        if($this->count() >= $this->size){
            throw new \Exception('Ohh Error');
        }
    }
    public function desasociaruno($user = null){
        return  $this->members()->where(['id' => $user->id])->update(['team_id' => null]);
    }

    public function desasociarTodos(){
        
            //return  $this->members()->where(['id' => $user->id])->update(['team_id' => null]);
            foreach ($this->members()->get() as $member) {
                $this->members()->where('id', '=', $member->id)->update(['team_id' => null]);
              }
      
              return $this->count();
        }

}
