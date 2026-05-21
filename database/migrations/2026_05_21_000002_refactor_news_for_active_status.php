<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('news', 'excerpt')) {
            if (Schema::hasColumn('news', 'summary')) {
                DB::table('news')->whereNull('summary')->update(['summary' => DB::raw('excerpt')]);

                Schema::table('news', function (Blueprint $table) {
                    $table->dropColumn('excerpt');
                });
            } else {
                Schema::table('news', function (Blueprint $table) {
                    $table->renameColumn('excerpt', 'summary');
                });
            }
        } elseif (! Schema::hasColumn('news', 'summary')) {
            Schema::table('news', function (Blueprint $table) {
                $table->string('summary', 500)->nullable()->after('slug');
            });
        }

        if (Schema::hasColumn('news', 'published_at')) {
            Schema::table('news', function (Blueprint $table) {
                $table->dropColumn('published_at');
            });
        }

        if (Schema::hasColumn('news', 'image')) {
            Schema::table('news', function (Blueprint $table) {
                $table->text('image')->nullable()->change();
            });
        }

        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE news MODIFY status VARCHAR(20) NOT NULL DEFAULT 'active'");
        } else {
            Schema::table('news', function (Blueprint $table) {
                $table->string('status', 20)->default('active')->change();
            });
        }

        DB::table('news')->where('status', 'published')->update(['status' => 'active']);
        DB::table('news')->where('status', 'draft')->update(['status' => 'inactive']);
        DB::table('news')->whereNotIn('status', ['active', 'inactive'])->update(['status' => 'active']);

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE news MODIFY status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE news MODIFY status VARCHAR(20) NOT NULL DEFAULT 'draft'");
        } else {
            Schema::table('news', function (Blueprint $table) {
                $table->string('status', 20)->default('draft')->change();
            });
        }

        DB::table('news')->where('status', 'active')->update(['status' => 'published']);
        DB::table('news')->where('status', 'inactive')->update(['status' => 'draft']);

        Schema::table('news', function (Blueprint $table) {
            if (! Schema::hasColumn('news', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('image');
            }
        });

        if (Schema::hasColumn('news', 'summary')) {
            if (Schema::hasColumn('news', 'excerpt')) {
                DB::table('news')->whereNull('excerpt')->update(['excerpt' => DB::raw('summary')]);

                Schema::table('news', function (Blueprint $table) {
                    $table->dropColumn('summary');
                });
            } else {
                Schema::table('news', function (Blueprint $table) {
                    $table->renameColumn('summary', 'excerpt');
                });
            }
        }

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE news MODIFY status ENUM('draft', 'published') NOT NULL DEFAULT 'draft'");
        }
    }
};
