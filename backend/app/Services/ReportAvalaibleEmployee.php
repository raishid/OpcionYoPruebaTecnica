<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Employee;
use Carbon\CarbonPeriod;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ReportAvalaibleEmployee implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{

  protected $start_time;
  protected $end_time;

  public function __construct($start_time, $end_time)
  {
    $this->start_time = $start_time;
    $this->end_time = $end_time;
  }

  public function collection()
  {
    return Employee::all();
  }

  public function headings(): array
  {
    return [
      'Nombre',
      'Apellido',
      'Horas disponibles',
      'Horas Reservadas',
    ];
  }

  public function map($employee): array
  {

    $periods = CarbonPeriod::create($this->start_time, '1 day', $this->end_time);

    $service = new EmployeeServices;

    $availables_horary_dates = $service->mapAvalaibleAndReservations($employee, $periods);

    $avalaibleTxt = '';

    $availables_horary_dates->avalaibles->each(function ($item) use (&$avalaibleTxt) {
      $avalaibleTxt .= Carbon::parse($item)->format('Y-m-d H:i:s') . "\n";
    });

    $reservations = '';

    $availables_horary_dates->reserves->each(function ($item) use (&$reservations) {
      $reservations .= Carbon::parse($item)->format('Y-m-d H:i:s') . "\n";
    });


    return [
      $employee->name,
      $employee->last_name,
      $avalaibleTxt,
      $reservations,
    ];
  }
  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle('A')->getAlignment()->setVertical('center');
    $sheet->getStyle('B')->getAlignment()->setVertical('center');
    $sheet->getStyle('C')->getAlignment()->setWrapText(true);
    $sheet->getStyle('C')->getAlignment()->setVertical('center');
    $sheet->getStyle('D')->getAlignment()->setWrapText(true);
    $sheet->getStyle('D')->getAlignment()->setVertical('center');
  }
}
