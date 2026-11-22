<?php

namespace App\Services;

use App\Room;
use App\StudentAcademicPlacement;
use Illuminate\Support\Facades\DB;

/** One read-operation snapshot, never retained by a writer or a container singleton. */
class AcademicVisitReadContext
{
    private $enabled;
    private $links;
    private $rooms;
    private $placements;

    public function __construct($records, array $roomIds = [])
    {
        $records = collect($records);
        $this->enabled = app(AcademicVisitRecords::class)->enabled();
        $this->links = collect();
        $this->rooms = collect();
        $this->placements = collect();
        if (!$this->enabled || $records->isEmpty()) return;
        foreach ($records->groupBy(function ($row) { return AcademicVisitRecords::TYPES[$row->getTable()]; }) as $type => $rows) {
            foreach (DB::table(AcademicVisitRecords::TABLE)->where('record_type', $type)->whereIn('record_id', $rows->pluck('id'))->get() as $link) {
                $this->links->put($type.':'.$link->record_id, $link);
            }
        }
        $this->rooms = Room::whereIn('id', $records->pluck('room_id')->merge($this->links->pluck('room_id'))->merge($roomIds)->unique())->get()->keyBy('id');
        $students = $records->map(function ($row) { return $row->student_id ?: $row->user_id; })->merge($this->links->pluck('student_id'))->unique();
        $years = $this->rooms->pluck('year_id')->merge($this->links->pluck('year_id'))->unique();
        $this->placements = StudentAcademicPlacement::whereIn('student_id', $students)->whereIn('year_id', $years)->get()
            ->groupBy(function ($placement) { return $placement->student_id.':'.$placement->year_id; });
    }

    public function link($record)
    {
        return $this->links->get(AcademicVisitRecords::TYPES[$record->getTable()].':'.$record->id);
    }

    public function resultState($record)
    {
        if (!$this->enabled) return null;
        $link = $this->link($record);
        if ($link) {
            $active = $this->placements->get($link->student_id.':'.$link->year_id, collect())->where('status', 'active');
            return $active->count() === 1 && (int)$active->first()->id === (int)$link->placement_id ? 'current' : 'carried';
        }
        $room = $this->rooms->get($record->room_id);
        $student = $record->student_id ?: $record->user_id;
        return $room && $this->placements->get($student.':'.$room->year_id, collect())->where('room_id', $room->id)->count() > 1
            ? 'conflict' : null;
    }

    public function roomName($roomId)
    {
        $room = $this->rooms->get($roomId);
        return $room ? $room->name : null;
    }
}
