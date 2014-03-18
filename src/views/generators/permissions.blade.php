{{ '<?php' }}

use Illuminate\Database\Migrations\Migration;

class PermissionsSetupPermissionsTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ $table }}', function($table)
        {
            $table->increments('id');

            $table->string('name');
            $table->string('key')->unique()->index();

            $table->timestamps();
        });

        Schema::create('{{ $pivot }}', function($table)
        {
            $table->increments('id');

            $table->integer('permission_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();

            $table->foreign('permission_id')->references('id')->on('{{ $table }}')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('{{ $auth }}')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('{{ $pivot }}');

        Schema::drop('{{ $table }}');
    }

}
