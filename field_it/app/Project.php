<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $guarded = ['id'];

    public function tasks()
    {
      return $this->hasMany('App\Task');
    }

    public function manager()
    {
      return $this->belongsTo('App\User', 'id', 'manager_id');
    }

    public function messages()
    {
      return $this->hasMany('App\Message');
    }

    public static function model_skeleton()
    {
        if(config("database.default") == "sqlsrv")
        {
            $skeleton = [];
            foreach (\DB::select("SELECT COLUMN_NAME, COLUMN_DEFAULT
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = N'projects'") as $field) {
                if($field->COLUMN_NAME != 'id')
                {
                    $skeleton[$field->COLUMN_NAME] = $field->COLUMN_DEFAULT ?? "";
                }
            }
            return $skeleton;
        } else if(config("database.default") == "mysql") {

            $skeleton = [];
            foreach (\DB::select('show columns from projects') as $field) {
            if($field->Field != 'id')
            {
                $skeleton[$field->Field] = "";
            }

            }
            return $skeleton;
        }

    }
}
