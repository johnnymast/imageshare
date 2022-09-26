<?php

namespace App\Console\Commands;

use App\Models\ImageUpload;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire uploaded images by their expire date.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $images = ImageUpload::where('expires_at', '<', Carbon::now())
            ->where('expired', '=', false)->get();

        if ($images->count() > 0) {
            foreach ($images as $image) {
                $image->expire();
            }
        }
        return 0;
    }
}
