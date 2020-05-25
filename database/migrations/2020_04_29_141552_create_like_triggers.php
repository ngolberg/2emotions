<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER `likes_AFTER_INSERT` AFTER INSERT ON `likes` FOR EACH ROW
            BEGIN
                UPDATE words SET rate=rate+1 WHERE id = NEW.word_id;
            END');
        DB::unprepared('CREATE DEFINER=`root`@`localhost` TRIGGER `2emotions`.`likes_BEFORE_DELETE` BEFORE DELETE ON `likes` FOR EACH ROW
            BEGIN
                UPDATE words SET rate=rate-1 WHERE id = OLD.word_id;
            END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `likes_AFTER_INSERT`');
        DB::unprepared('DROP TRIGGER `likes_BEFORE_DELETE`');
    }
}
