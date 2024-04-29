<?php

namespace App\Exports;

use App\Models\ApprovalRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;

class GoalExport implements FromView, WithStyles
{
    use Exportable;

    protected $groupCompany;
    protected $location;
    protected $company;

    public function __construct($groupCompany, $location, $company)
    {
        $this->groupCompany = $groupCompany;
        $this->location = $location;
        $this->company = $company;
    }

    public function view(): View
    {
        $query = ApprovalRequest::query();

        // Apply filters if they are provided
        if ($this->groupCompany) {
            $query->whereHas('employee', function ($query) {
                $query->where('group_company', $this->groupCompany);
            });
        }

        if ($this->location) {
            $query->whereHas('employee', function ($query) {
                $query->where('work_area_code', $this->location);
            });
        }

        if ($this->company) {
            $query->whereHas('employee', function ($query) {
                $query->where('contribution_level_code', $this->company);
            });
        }

        $goals = $query->with(['employee', 'manager', 'goal', 'initiated'])->get();

        dd($goals);

        return view('exports.goal', [
            'goals' => $goals
        ]);
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFFF00']]
            ],
        ];
    }
}
