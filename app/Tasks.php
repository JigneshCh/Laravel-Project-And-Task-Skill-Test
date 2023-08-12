<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

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
    protected $fillable = ['name', 'content','project_id','priority'];
	
	protected $appends = ['created'];
	
    /**
     * Get formated date from timestamp.
     *
     */
	public function getCreatedAttribute()
    {
        if($this->created_at != "" && $this->created_at){
            return \Carbon\Carbon::parse($this->created_at)->format("jS M Y g:i A");
        }
        return $this->created_at;
    }
	
    /**
     * Bind the task creating event to auto find new/default priority.
     *
     */
	public static function boot()
    {
        parent::boot();
		static::creating(function ($model) {
			$priority = 1;
			if($model->project){
				$priority = $model->project->nextPriority();
			}
			$model->priority = $priority;	
		});
	}
	
    /**
     * Task belongs to on project.
     *
     */
	public function project()
    {
        return $this->belongsTo('App\Projects', 'project_id', 'id');
    }
}