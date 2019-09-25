<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('notifications', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->uuid('notification_id');
			$table->string('notification_type');
			$table->string('subject');
			$table->longText('description');
			$table->boolean('status')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('notifications');
	}
}