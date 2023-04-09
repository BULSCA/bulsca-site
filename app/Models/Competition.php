<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'when' => 'datetime',
        'status' => CompetitionStatus::class
    ];

    public function hostUni()
    {
        return $this->hasOne(University::class, 'id', 'host');
    }

    public function currentSeason()
    {
        return $this->hasOne(Season::class, 'id', 'season');
    }

    public function getResultsResource()
    {
        return $this->hasOne(Resource::class, 'id', 'results_resource');
    }

    public function getPackResource()
    {
        return $this->hasOne(Resource::class, 'id', 'pack_resource');
    }

    public function hasResults()
    {
        return $this->results_type == "NONE" ? false : true;
    }

    public function getStatus()
    {
        if (now() > $this->when) {
            return "competition-status-finished";
        } else {
            return "";
        }
    }

    public function getName()
    {
        return $this->hostUni->name . " " . $this->when->format('Y');
    }

    public function getInfo()
    {
        return $this->hasOne(CompetitionInfo::class, 'competition', 'id');
    }

    public function setResults(ResultType $type, $link)
    {
        $this->results_type = $type;
        $this->results_link = $link;
        $this->save();
    }

    public function getResults()
    {

        if ($this->results_resource != null) {
            return $this->getResultsResource()->first();
        }

        if ($this->results_type == "RESOURCE") {
            $r = Resource::find($this->results_link);
            return ["name" => $r->name, "link" => $r->getURL()];
        }
        return ["name" => $this->getName() . " Results", "link" => $this->results_link, "type" => "link"];
    }
}

enum ResultType: string
{
    case RESOURCE = "RESOURCE";
    case LINK = "LINK";
    case NONE = "NONE";
}

enum CompetitionStatus: string
{
    case READY = 'ready';
    case FINISHED = 'finished';
    case AWAITING_RESULTS = 'awaiting_results';
    case INCOMPLETE_SETUP = 'incomplete_setup';

    public function toCSSStatus(): string
    {
        return match ($this) {
            CompetitionStatus::READY => 'competition-status-ready',
            CompetitionStatus::FINISHED => 'competition-status-finished',
            CompetitionStatus::AWAITING_RESULTS => 'competition-status-results',
            CompetitionStatus::INCOMPLETE_SETUP => 'competition-status-alert'
        };
    }

    public function toStatusMessage(): string
    {
        return match ($this) {
            CompetitionStatus::READY => 'This competition is ready to take place',
            CompetitionStatus::FINISHED => 'This competition is fully finished',
            CompetitionStatus::AWAITING_RESULTS => 'This competition still needs its results uploading!',
            CompetitionStatus::INCOMPLETE_SETUP => 'This competition has not been fully setup!'
        };
    }

    public function toBadgeCSS(): string
    {
        return match ($this) {
            CompetitionStatus::READY => 'success',
            CompetitionStatus::FINISHED => 'success',
            CompetitionStatus::AWAITING_RESULTS => 'warning',
            CompetitionStatus::INCOMPLETE_SETUP => 'alert'
        };
    }

    public function toBadgeMessage(): string
    {
        return match ($this) {
            CompetitionStatus::READY => 'Ready to go',
            CompetitionStatus::FINISHED => 'Complete',
            CompetitionStatus::AWAITING_RESULTS => 'Waiting for Results',
            CompetitionStatus::INCOMPLETE_SETUP => 'Incomplete Setup'
        };
    }
}
