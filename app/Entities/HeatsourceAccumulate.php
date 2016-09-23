<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use DB;

class HeatsourceAccumulate extends Model
{
    protected $table = 'HeatSourceAccuHistory';

    protected $primaryKey = 'ItemID';

    public function heatsource()
    {
    	return $this->belongsTo('App\Entities\Heatsource');
    }

    public function allSublines()
    {
        return HeatsourceAccumulate::where('heatsource_id', $this->heatsource_id)
            ->select('subline_num', 'heat_daily_gj', 'date');
    }

    public function stations()
    {
        return $this->hasMany('App\Entities\Station', 
            'heatsource_id', 'heatsource_id');
    }

    public function stationAccumulate()
    {
        return DB::table('HeatSourceAccuHistory')->leftJoin('Stations', 
                'Stations.heatsource_id', 'HeatSourceAccuHistory.heatsource_id')
                ->leftJoin('StationAccuHistory', 'StationAccuHistory.station_id', 'Stations.ItemID')
            ->select('station_id', 'StationAccuHistory.area_in_use', 'HeatSourceAccuHistory.date');
    }

    public function temperature()
    {
        return $this->hasOne('App\Entities\Weather4','date', 'date');
    }

    public function totalNetHistory()
    {
        return $this->hasOne('App\Entities\TotalNetHistory','date', 'date')->whereItemid( 3);
    }

    public function scopeEast( $query )
    {
        return $query->where('district_id', 1);
    }

    public function scopeWest( $query )
    {
        return $query->where('district_id', 2);
    }

    public function scopeInner( $query )
    {
        return $query->where('inner_or_outer', 1);
    }

    public function scopeOuter( $query )
    {
        return $query->where('inner_or_outer', 0);
    }

    public function getTotalHeatDailyGjAttribute()
    {
        return $this->allSublines()->where('date',$this->date )->sum('heat_daily_gj');
    }

    public function getAreaInUseAttribute()
    {
        return $this->stationAccumulate()->where('HeatSourceAccuHistory.date',$this->date)->sum('StationAccuHistory.area_in_use');
    }

    public function getHeatPerSquareActualAttribute()
    {
        return $this->total_heat_daily_gj/$this->area_in_use;
    }

    public function getBlockArrayAttribute()
    {
        return array(
            'id' => $this->ItemID,
            'heatsource_id' => (int) $this->heatsource_id,
            'heatsource_name' => $this->heatsource->name,
            'heat_daily_gj' =>  (int)$this->total_heat_daily_gj,
            'date' => $this->date,
            'temperature_perdict' => $this->temperature->temperature_perdict,
            'temperature_actual' =>  $this->temperature->temperature_actual,
            'heat_per_square_actual' => $this->heat_per_square_actual,
            'area_in_use' => $this->area_in_use
        );
    }

}
