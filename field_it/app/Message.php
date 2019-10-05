<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

  protected $guarded = ['id'];

  public function project()
  {
    return $this->belongsTo('App\Project');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public static function model_skeleton()
  {
      if(config("database.default") == "sqlsrv")
      {
          $skeleton = [];
          foreach (\DB::select("SELECT COLUMN_NAME, COLUMN_DEFAULT
          FROM INFORMATION_SCHEMA.COLUMNS
          WHERE TABLE_NAME = N'messages'") as $field) {
              if($field->COLUMN_NAME != 'id')
              {
                  $skeleton[$field->COLUMN_NAME] = $field->COLUMN_DEFAULT ?? "";
              }
          }
          return $skeleton;
      } else if(config("database.default") == "mysql") {

          $skeleton = [];
          foreach (\DB::select('show columns from messages') as $field) {
          if($field->Field != 'id')
          {
              $skeleton[$field->Field] = "";
          }

          }
          return $skeleton;
      }

  }
}
