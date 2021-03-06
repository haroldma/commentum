<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculateHotnessFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<SQL
DROP FUNCTION IF EXISTS calculateHotnessFromMomentum;
CREATE FUNCTION calculateHotnessFromMomentum(impressions INTEGER, views INTEGER, comment_momentum DOUBLE, created DATETIME)
RETURNS DOUBLE
BEGIN
    DECLARE score INTEGER;
    DECLARE seconds FLOAT;

    SET score = calculateThreadMomentum(impressions, views, comment_momentum);
    SET seconds = UNIX_TIMESTAMP(created) - 1430006400;

    RETURN ROUND(score + seconds / 45000, 7);
END
SQL;
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP FUNCTION IF EXISTS calculateHotnessFromMomentum;");
    }
}
