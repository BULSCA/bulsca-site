<?php

namespace App\Services;

use App\Models\{Article, Casualty\Casualty, Casualty\CasualtyGroup, ClubPage, Committee\Committee, Committee\CommitteeMember, Committee\CommitteeRole, Competition, CompetitionInfo, CompetitionUniPlace, GlobalNotification, LeaguePlace, Resource, ResourcePage, ResourcePageSection, ResourcePageSectionResource, Season, SeasonUni, SERC\SERC, SERC\SERCTag, Tag, University};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Monotonic content revision for the public website. Prerenderers compare the
 * revision to decide whether published pages changed. It moves only after a
 * committed public-content write and never on reads or rolled-back writes.
 */
class PublicContentRevision
{
    /** Models whose committed changes alter public pages or their data. */
    public const WATCHED = [
        Article::class, Tag::class, University::class, ClubPage::class,
        Committee::class, CommitteeMember::class, CommitteeRole::class,
        Season::class, SeasonUni::class, LeaguePlace::class, CompetitionUniPlace::class,
        Competition::class, CompetitionInfo::class,
        Resource::class, ResourcePage::class, ResourcePageSection::class, ResourcePageSectionResource::class,
        SERC::class, SERCTag::class, Casualty::class, CasualtyGroup::class,
        GlobalNotification::class,
    ];

    /** Columns changed by ordinary page reads or bookkeeping, never by editors. */
    private const IGNORABLE = ['views', 'thumbs_up', 'thumbs_down', 'created_at', 'updated_at'];

    public function register(): void
    {
        foreach (self::WATCHED as $model) {
            $model::saved(fn (Model $record) => $this->note($record));
            $model::deleted(fn () => $this->note());
            // The restored event only exists on soft-delete models.
            if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($model), true)) {
                $model::restored(fn () => $this->note());
            }
        }
    }

    public function current(): int
    {
        return (int) (DB::table('public_site_revisions')->where('id', 1)->value('revision') ?? 0);
    }

    /** Record one content change; the revision only moves once the transaction commits. */
    public function note(?Model $record = null): void
    {
        if ($record !== null && $this->contentChanges($record) === []) return;
        DB::afterCommit(fn () => $this->bump());
    }

    private function contentChanges(Model $record): array
    {
        return array_values(array_diff(array_keys($record->getChanges()), self::IGNORABLE));
    }

    private function bump(): void
    {
        DB::table('public_site_revisions')->where('id', 1)->update([
            'revision' => DB::raw('revision + 1'),
            'updated_at' => now(),
        ]);
    }
}
