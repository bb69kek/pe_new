<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Halt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HaltCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:halt-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('This is an informational message.');

        $today = Carbon::now()->format('Y/m/d');
        $hour = str_pad(Carbon::now()->format('H'), 2, '0', STR_PAD_LEFT);
        $minute = str_pad(Carbon::now()->format('i'), 2, '0', STR_PAD_LEFT);
        $time = $hour.':'.$minute;
        Log::info(['current: ', $today, $time]);
        $halts = halt::where('day', $today)->where('hour', $time)->get();
        Log::info(['to run: ', count($halts)]);
        foreach ($halts as $key => $halt) {
            // approval check
            $now = Carbon::now()->format('h:i A, d/m/Y');

            $halt->update(['status' => 'ongoing', 'haltStart' => $now]);
        }

        $ongoingHalts = halt::where('status', 'ongoing')->get();
        Log::info(['ongoing: ', count($ongoingHalts)]);
        foreach ($ongoingHalts as $key => $halt) {

            $start = Carbon::createFromFormat('h:i A, d/m/Y', $halt['haltStart']);
            $dur = (int) $halt['duration'];
            // Log::info(['start', $start->format('h:i:s A, d/m/Y'), 'dur', $dur]);

            $start->addSeconds($dur);

            $now = Carbon::now();
            // $now->setSeconds(0);

            $eq = $now->timestamp >= $start->timestamp;
            Log::info(['start and dur', $start->format('h:i:s A, d/m/Y'), 'now', $now->format('h:i:s A, d/m/Y'), 'equal', $eq]);


            if($eq) {
                $halt->update(['status' => 'finished', 'haltEnd' => $now->format('h:i A, d/m/Y')]);
            }
            $ns = $halt->dataSent + rand(100, 1000);
            $halt->update(['dataSent' => $ns]);
        }

        return Command::SUCCESS;
    }
}
