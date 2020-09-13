<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/23/2019
 * Time: 4:25 PM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use JoyBusinessAcademy\Profile\Events\EducationCreated;
use JoyBusinessAcademy\Profile\Events\EducationDeleted;
use JoyBusinessAcademy\Profile\Events\EducationUpdated;
use JoyBusinessAcademy\Profile\Events\ExperienceCreated;
use JoyBusinessAcademy\Profile\Events\ExperienceDeleted;
use JoyBusinessAcademy\Profile\Events\ExperienceUpdated;
use JoyBusinessAcademy\Profile\Events\ProfileCreated;
use JoyBusinessAcademy\Profile\Events\ProfileUpdated;
use JoyBusinessAcademy\Profile\Events\ReferenceCreated;
use JoyBusinessAcademy\Profile\Events\ReferenceDeleted;
use JoyBusinessAcademy\Profile\Events\ReferenceUpdated;
use JoyBusinessAcademy\Profile\Events\SkillCreated;
use JoyBusinessAcademy\Profile\Events\SkillDeleted;
use JoyBusinessAcademy\Profile\Events\SkillUpdated;
use JoyBusinessAcademy\Profile\Models\Education;
use JoyBusinessAcademy\Profile\Models\Experience;
use JoyBusinessAcademy\Profile\Models\Profile;
use JoyBusinessAcademy\Profile\Models\Reference;
use JoyBusinessAcademy\Profile\Models\Skill;

trait RefreshesProfileCache
{
    public static function bootRefreshesProfileCache()
    {
        static::created(function(Model $model) {
            app('JBAProfileGateway')->forgetCachedProfile();

            if($model instanceof Profile) {
                Event::fire(new ProfileCreated($model));
            }
            elseif($model instanceof Skill) {
                Event::fire(new SkillCreated($model));
            }
            elseif($model instanceof Experience) {
                Event::fire(new ExperienceCreated($model));
            }
            elseif($model instanceof Education) {
                Event::fire(new EducationCreated($model));
            }
            elseif($model instanceof Reference) {
                Event::fire(new ReferenceCreated($model));
            }
        });

        static::updated(function(Model $model) {
            app('JBAProfileGateway')->forgetCachedProfile();

            if($model instanceof Profile) {
                Event::fire(new ProfileUpdated($model));
            }
            elseif($model instanceof Skill) {
                Event::fire(new SkillUpdated($model));
            }
            elseif($model instanceof Experience) {
                Event::fire(new ExperienceUpdated($model));
            }
            elseif ($model instanceof Education) {
                Event::fire(new EducationUpdated($model));
            }
            elseif($model instanceof Reference) {
                Event::fire(new ReferenceUpdated($model));
            }
        });

        static::deleted(function(Model $model) {
            app('JBAProfileGateway')->forgetCachedProfile();

            if($model instanceof Skill) {
                Event::fire(new SkillDeleted($model));
            }
            elseif($model instanceof Experience) {
                Event::fire(new ExperienceDeleted($model));
            }
            elseif($model instanceof Education) {
                Event::fire(new EducationDeleted($model));
            }
            elseif($model instanceof Reference) {
                Event::fire(new ReferenceDeleted($model));
            }
        });
    }
}