<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Vehicle;

class CalendarWidget extends Widget
{
	/**
	 * Расположение и ширина виджета: во всю ширину.
	 *
	 * @var string|int
	 */
	protected array|string|int $columnSpan = 'full';

	/**
	 * Порядок вывода виджета (меньше — выше).
	 *
	 * @var int|null
	 */
	protected static ?int $sort = 0;

	/**
	 * Ленивая загрузка через AJAX.
	 *
	 * @var bool
	 */
	protected static bool $isLazy = false;

	/**
	 * Blade-вид, который рендерит календарь и список машин.
	 *
	 * @var string
	 */
	protected static string $view = 'filament.widgets.calendar-widget';

	/**
	 * Все машины из БД.
	 *
	 * @var \Illuminate\Database\Eloquent\Collection<int, Vehicle>
	 */
	public $vehicles;

	/**
	 * Данные для календаря: месяцы, статусы, суммы.
	 *
	 * @var array<string, mixed>
	 */
	public array $demoData = [];

	/**
	 * Загружаем машины и генерируем данные при инициализации.
	 *
	 * @return void
	 */
	public function mount(): void
	{
		$this->vehicles = Vehicle::all();
		$this->demoData = $this->generateDemoData();
	}

	/**
	 * Прокидываем данные в шаблон Livewire.
	 *
	 * @return array<string, mixed>
	 */
	public function getWidgetData(): array
	{
		return [
			'vehicles' => $this->vehicles,
			'months'   => $this->demoData['months'],
			'data'     => $this->demoData['data'],
			'rowSums'  => $this->demoData['rowSums'],
		];
	}

	/**
	 * Генерируем демонстрационные данные для календаря.
	 *
	 * @return array<string, mixed>
	 */
	protected function generateDemoData(): array
	{
		$badgeKeys    = ['О','П','Р','В'];
		$monthsConfig = [
			['name'=>'Травень','month'=>5,'year'=>2025,'days'=>29],
			['name'=>'Квітень','month'=>4,'year'=>2025,'days'=>30],
			['name'=>'Березень','month'=>3,'year'=>2025,'days'=>31],
			['name'=>'Лютий','month'=>2,'year'=>2025,'days'=>28],
			['name'=>'Січень','month'=>1,'year'=>2025,'days'=>31],
		];

		// Разворачиваем дни в массивы
		$months = [];
		foreach ($monthsConfig as $cfg) {
			$months[] = array_merge($cfg, [
				'days' => range(1, $cfg['days']),
			]);
		}

		$data    = [];
		$rowSums = [];

		// Присваиваем каждой машине случайный статус на каждый день
		foreach ($this->vehicles as $v) {
			$id           = $v->id;
			$rowSums[$id] = [];

			foreach ($months as $mi => $month) {
				foreach ($month['days'] as $day) {
					$status                       = $badgeKeys[array_rand($badgeKeys)];
					$data[$id][$mi][$day]        = $status;
					$rowSums[$id][$mi][$status] = ($rowSums[$id][$mi][$status] ?? 0) + 1;
				}
			}
		}

		return [
			'months'  => $months,
			'data'    => $data,
			'rowSums' => $rowSums,
		];
	}
}
