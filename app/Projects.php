<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status'];
	
    /**
     * Project can have multiple tasks.
     *
     */
	public function tasks()
    {
        return $this->hasMany('App\Tasks', 'project_id', 'id')->orderby('priority');
    }

    /**
     * Get new priority for newly creating task for project.
     *
     */
	public function nextPriority()
    {
        return ($this->tasks->max('priority') + 1 );
    }
}
